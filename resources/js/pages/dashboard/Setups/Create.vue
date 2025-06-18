<script setup lang="ts">
import { vAutoAnimate } from '@formkit/auto-animate/vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from "@/types";
import { useForm } from 'vee-validate';
import
{
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import { Select, SelectTrigger, SelectValue, SelectContent, SelectItem } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { toTypedSchema } from '@vee-validate/zod';
import { toast } from 'vue-sonner';
import * as z from 'zod';
import 'vue-sonner/style.css';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Setup',
        href: '/dashboard/setups/create'
    },
];

const props = defineProps<{
    simulators: Array<{ id: number; name: string }>;
    tracks: Array<{ id: number; name: string }>;
    cars: Array<{ id: number; name: string }>;
}>();

const formSchema = toTypedSchema(z.object({
    simulator_id: z.number().int().positive({ message: 'Select simulator' }),
    track_id: z.number().int().positive({ message: 'Select track' }),
    car_id: z.number().int().positive({ message: 'Select car' }),
    lap_time_ms: z.string().min(1, { message: 'Best laptime is required' }),
    lap_time_recorded_at: z.string().optional(),
    setup_type: z.string().min(1, { message: 'Type is required' }),
    setup_data: z.instanceof(File, { message: 'Setup file is required' }),
    is_public: z.boolean().optional(),
}));

const form = useForm({
    validationSchema: formSchema
});

const onSubmit = form.handleSubmit(async (values) =>
{
    const formData = new FormData();
    formData.append('simulator_id', values.simulator_id as any);
    formData.append('track_id', values.track_id as any);
    formData.append('car_id', values.car_id as any);
    formData.append('lap_time_ms', values.lap_time_ms);
    formData.append('lap_time_recorded_at', values.lap_time_recorded_at?.toString() ?? '');
    formData.append('setup_type', values.setup_type);
    formData.append('setup_data', values.setup_data as File);
    formData.append('is_public', values.is_public ? '1' : '0');

    try {
        await axios.post(route('api.setups.store'), formData);
        toast.success('Setup created succesfully');
    } catch (error) {
        toast.error('Failed to create setup');
        console.error(error);
    }
});
</script>

<template>

    <Head title="Create Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <form @submit="onSubmit" class="flex flex-col space-y-2">
                    <FormField name="simulator_id" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Simulator</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select a simulator" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="s in props.simulators" :key="s.id" :value="s.id">{{ s.name }}</SelectItem>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="track_id" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Track</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select a track" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="t in props.tracks" :key="t.id" :value="t.id">{{ t.name }}</SelectItem>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="car_id" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Car</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select a car" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="c in props.cars" :key="c.id" :value="c.id">{{ c.name }}</SelectItem>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="lap_time_ms" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Best Lap Time</FormLabel>
                            <FormControl>
                                <Input v-bind="componentField" placeholder="1:45.678" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="lap_time_recorded_at" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Lap Time Recorded At</FormLabel>
                            <FormControl>
                                <Input type="date" v-bind="componentField" placeholder="2025-01-01 13:30:00" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_type" v-slot="{ componentField }">
                        <FormItem v-auto-animate>
                            <FormLabel>Setup Type</FormLabel>
                            <FormControl>
                                <Input v-bind="componentField" placeholder="e.g. Quali, Race" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_data" v-slot="{ handleChange }">
                        <FormItem v-auto-animate>
                            <FormLabel>Setup File</FormLabel>
                            <FormControl>
                                <Input type="file" id="setup_data" accept=".json" @input="(e: Event) => { handleChange(e); form.setFieldValue('setup_data', (e.target as HTMLInputElement).files?.[0]!) }" class="file:mr-4 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="is_public" v-slot="{ value, handleChange }">
                        <FormItem v-auto-animate class="flex items-center gap-2">
                            <Switch :model-value="value" @update:model-value="handleChange" />
                            <FormLabel class="mb-0">Public</FormLabel>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <div class="flex justify-end space-x-2 mt-4">
                        <Button variant="secondary" type="reset" @click="form.resetForm()">Reset</Button>
                        <Button type="submit">Save Setup</Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
