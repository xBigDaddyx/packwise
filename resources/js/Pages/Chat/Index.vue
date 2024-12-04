<script setup>
import InputError from '@/Components/InputError.vue'
import { Button } from '@/Components/shadcn/ui/button'
import { Label } from '@/Components/shadcn/ui/label'
import Skeleton from '@/Components/shadcn/ui/skeleton/Skeleton.vue'
import { Textarea } from '@/Components/shadcn/ui/textarea'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useFetch } from '@vueuse/core'
import { ref } from 'vue'
import ModelSelector from './Components/ModelSelector.vue'
import TemperatureSelector from './Components/TemperatureSelector.vue'

const props = defineProps({
  systemPrompt: String,
  models: Array,
})

const userInput = ref('')
const modelOutput = ref(null)
const error = ref(null)

const selectedModel = ref(props.models[0])
function onModelSelect(model) {
  selectedModel.value = model
}

async function submit() {
  if (!userInput.value.trim()) {
    error.value = 'Please enter a message'
    return
  }

  error.value = null

  const { data, error: fetchError } = await useFetch('/prism/openai/v1/chat/completions', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      model: selectedModel.value,
      messages: [
        { role: 'user', content: userInput.value },
      ],
    }),
  }).json()

  if (fetchError.value) {
    error.value = fetchError.value
  }
  else {
    modelOutput.value = data.value.choices[0].message.content
  }
}
</script>

<template>
  <AppLayout title="Larasonic AI Playground">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Larasonic AI Playground
      </h2>
    </template>
    <div class="h-full flex-col flex">
      <div class="flex-1">
        <div class="h-full">
          <div class="grid h-full items-stretch gap-6 md:grid-cols-[minmax(0,1fr)_180px]">
            <div class="flex-col space-y-4 flex md:order-2">
              <ModelSelector :models="props.models" @update:model-select="onModelSelect" />
              <TemperatureSelector />
            </div>
            <div class="order-1">
              <div class="mt-0 border-0 p-0">
                <div class="flex flex-col space-y-4">
                  <div class="grid h-full gap-6 lg:grid-cols-2">
                    <div class="flex flex-col space-y-4">
                      <div class="flex flex-1 flex-col space-y-2">
                        <Label for="input">System Input</Label>
                        <Textarea
                          id="input" disabled :default-value="systemPrompt"
                          class="flex-1 lg:min-h-[320px]"
                        />
                      </div>
                      <div class="flex flex-col space-y-2">
                        <Label for="instructions">User Input</Label>
                        <Textarea
                          id="instructions" v-model="userInput"
                          class="lg:min-h-[320px]"
                        />
                      </div>
                    </div>
                    <div class="flex flex-col space-y-2">
                      <Label for="output">Model Output</Label>
                      <Skeleton v-if="!modelOutput" class="h-20 sm:h-full min-h-[400px]lg:min-h-[700px] rounded-md" />
                      <Textarea
                        v-else id="output"
                        disabled
                        class="min-h-[400px] rounded-md bg-muted border lg:min-h-[700px]"
                        :default-value="modelOutput"
                      />
                    </div>
                  </div>
                  <div class="flex items-center space-x-2" v-if="!modelOutput">
                    <Button @click.prevent="submit">
                      <span>Submit</span>
                    </Button>
                    <InputError :message="error" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
