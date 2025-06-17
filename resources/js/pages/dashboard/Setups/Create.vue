<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
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
import { h } from 'vue'
import * as z from 'zod';
import 'vue-sonner/style.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Setup',
        href: '/dashboard/setups/create'
    }
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

const { handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: {
        simulator_id: 0,
        track_id: 0,
        car_id: 0,
        lap_time_ms: '',
        lap_time_recorded_at: '',
        setup_type: '',
        setup_data: undefined,
        is_public: false,
    }
});

const onSubmit = handleSubmit((values) =>
{
    toast('You submitted the following values:', {
        description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
    })
});
</script>

<template>

    <Head title="Create Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <form @submit="onSubmit" class="flex flex-col space-y-2">
                    <FormField name="simulator_id" v-slot="{ componentField }">
                        <FormItem>
                            <FormLabel>Simulator</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField" @blur="componentField.blur">
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
                        <FormItem>
                            <FormLabel>Track</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField" @blur="componentField.blur">
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
                        <FormItem>
                            <FormLabel>Car</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField" @blur="componentField.blur">
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
                        <FormItem>
                            <FormLabel>Best Lap Time</FormLabel>
                            <FormControl>
                                <Input v-bind="componentField" placeholder="1:45.678" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="lap_time_recorded_at" v-slot="{ componentField }">
                        <FormItem>
                            <FormLabel>Lap Time Recorded At</FormLabel>
                            <FormControl>
                                <Input v-bind="componentField" placeholder="2025-01-01 13:30:00" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_type" v-slot="{ componentField }">
                        <FormItem>
                            <FormLabel>Setup Type</FormLabel>
                            <FormControl>
                                <Input v-bind="componentField" placeholder="e.g. Quali, Race" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_data" v-slot="{ handleChange, handleBlur }">
                        <FormItem>
                            <FormLabel>Setup JSON File</FormLabel>
                            <FormControl>
                                <Input type="file" id="setup_data" accept=".json" @change="handleChange" @blur="handleBlur" class="file:mr-4 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="is_public" v-slot="{ value, handleChange }">
                        <FormItem class="flex items-center gap-2">
                            <Switch :model-value="value" @update:model-value="handleChange" />
                            <FormLabel class="mb-0">Public</FormLabel>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <div class="flex justify-end space-x-2 mt-4">
                        <Button variant="secondary" type="reset" @click="form.reset()">Reset</Button>
                        <Button type="submit">Save Setup</Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
