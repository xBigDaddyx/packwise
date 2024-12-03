<script setup>
import { Button } from '@/Components/shadcn/ui/button'
import { Label } from '@/Components/shadcn/ui/label'
import { Textarea } from '@/Components/shadcn/ui/textarea'
import AppLayout from '@/Layouts/AppLayout.vue'

import ModelSelector from './Components/ModelSelector.vue'
import TemperatureSelector from './Components/TemperatureSelector.vue'
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
              <ModelSelector />
              <TemperatureSelector/>
            </div>
            <div class="order-1">
              <div class="mt-0 border-0 p-0">
                <div class="flex flex-col space-y-4">
                  <div class="grid h-full gap-6 lg:grid-cols-2">
                    <div class="flex flex-col space-y-4">
                      <div class="flex flex-1 flex-col space-y-2">
                        <Label for="input">System Input</Label>
                        <Textarea
                          id="input"
                          class="flex-1 lg:min-h-[320px]"
                        />
                      </div>
                      <div class="flex flex-col space-y-2">
                        <Label for="instructions">User Input</Label>
                        <Textarea
                          id="instructions"
                          class="lg:min-h-[320px]"
                        />
                      </div>
                    </div>
                    <div class="flex flex-col space-y-2">
                      <Label for="output">Model Output</Label>
                      <Textarea
                        id="output" disabled
                        class="min-h-[400px] rounded-md bg-muted border lg:min-h-[700px]"
                      />
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <Button>Submit</Button>
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
