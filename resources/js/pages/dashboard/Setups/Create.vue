<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm as veeForm } from 'vee-validate';
import { useForm as inertiaForm } from '@inertiajs/vue3';
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

const { handleSubmit } = veeForm({ validationSchema: formSchema });

const form = inertiaForm({
    simulator_id: null,
    track_id: null,
    car_id: null,
    lap_time_ms: '',
    lap_time_recorded_at: null,
    setup_type: '',
    setup_data: null,
    is_public: false,
});

const onSubmit = handleSubmit(() =>
{
    const payload = new FormData();
    payload.append('simulator_id', form.simulator_id as any);
    payload.append('track_id', form.track_id as any);
    payload.append('car_id', form.car_id as any);
    payload.append('lap_time_ms', form.best_lap_time);
    payload.append('lap_time_recorded_at', form.best_lap_time);
    payload.append('setup_type', form.setup_type);
    payload.append('setup_data', form.setup_data as File);
    payload.append('is_public', form.is_public ? '1' : '0');

    form.post(route('api.setups.store'), {
        data: payload,
        forceFormData: true,
        onSuccess: () =>
        {
            form.reset();

            toast('Setup has been successfully created!', {
                description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
            })
        },
    });
});
</script>

<template>

    <Head title="Create Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <form @submit="onSubmit" class="flex flex-col space-y-2">
                    <FormField name="simulator_id" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Simulator</FormLabel>
                            <FormControl>
                                <Select v-bind="field" @blur="field.blur">
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

                    <FormField name="track_id" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Track</FormLabel>
                            <FormControl>
                                <Select v-bind="field" @blur="field.blur">
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

                    <FormField name="car_id" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Car</FormLabel>
                            <FormControl>
                                <Select v-bind="field" @blur="field.blur">
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

                    <FormField name="lap_time_ms" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Best Lap Time</FormLabel>
                            <FormControl>
                                <Input v-bind="field" placeholder="1:45.678" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="lap_time_recorded_at" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Lap Time Recorded At</FormLabel>
                            <FormControl>
                                <Input v-bind="field" placeholder="2025-01-01 13:30:00" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_type" v-slot="{ field }">
                        <FormItem>
                            <FormLabel>Setup Type</FormLabel>
                            <FormControl>
                                <Input v-bind="field" placeholder="e.g. Quali, Race" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField name="setup_data" v-slot="{ handleChange }">
                        <FormItem>
                            <FormLabel>Setup File</FormLabel>
                            <FormControl>
                                <Input type="file" id="setup_data" accept=".json" @change="(e) => { handleChange(e); form.setup_data = (e.target.files?.[0]!) }" class="file:mr-4 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
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
