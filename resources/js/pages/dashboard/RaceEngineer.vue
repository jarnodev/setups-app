<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";
import { useForm as veeForm } from 'vee-validate';
import { useForm as inertiaForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Select, SelectTrigger, SelectValue, SelectContent, SelectItem } from "@/components/ui/select";
import { Button } from '@/components/ui/button';
import { toTypedSchema } from '@vee-validate/zod';
import { toast } from 'vue-sonner';
import { h } from 'vue'
import * as z from 'zod';
import 'vue-sonner/style.css';
import
{
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Race Engineer",
        href: "/dashboard/race-engineer",
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
    setup_type: z.string().min(1, { message: 'Type is required' }),
    setup_data: z.instanceof(File, { message: 'Setup file is required' }),
}));

const { handleSubmit } = veeForm({ validationSchema: formSchema });

const form = inertiaForm({
    simulator_id: 0,
    track_id: 0,
    car_id: 0,
    setup_type: '',
    setup_data: undefined,
});

const setup = null;

const onSubmit = handleSubmit(() =>
{
    const payload = new FormData();
    payload.append('simulator_id', form.simulator_id as any);
    payload.append('track_id', form.track_id as any);
    payload.append('car_id', form.car_id as any);
    payload.append('setup_type', form.setup_type);
    payload.append('setup_data', form.setup_data as File);

    form.post(route('api.setups.generate'), {
        data: payload,
        forceFormData: true,
        onSuccess: () =>
        {
            form.reset();

            toast('Race Engineer is done adjusting your setup!', {
                description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
            })
        }
    });
});
</script>

<template>

    <Head title="Race Engineer" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="max-w-3xl mx-auto py-10 px-4">
                    <form @submit="onSubmit" class="flex flex-col space-y-4">
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

                        <FormField name="setup_type" v-slot="{ componentField }">
                            <FormItem>
                                <FormLabel>Setup Type</FormLabel>
                                <FormControl>
                                    <Input v-bind="componentField" placeholder="e.g. Qualifying, Race" />
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

                        <Button type="submit" class="w-full">
                            Generate Setup
                        </Button>
                    </form>

                    <div v-if="setup" class="mt-8 bg-card border rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl font-semibold mb-4 text-center">Your Setup</h2>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                {{ JSON.stringify(setup) }}
                            </div>
                        </div>
                        <!-- <div class="mt-4 text-sm text-muted-foreground border-t pt-3">
                            <b>Note:</b> {{ setup.explanation }}
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
