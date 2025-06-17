<script setup lang="ts">
import { vAutoAnimate } from '@formkit/auto-animate/vue'
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";
import { useForm } from 'vee-validate';
import { Input } from '@/components/ui/input';
import { Select, SelectTrigger, SelectValue, SelectContent, SelectItem } from "@/components/ui/select";
import { Button } from '@/components/ui/button';
import { toTypedSchema } from '@vee-validate/zod';
import { toast } from 'vue-sonner';
import axios from 'axios';
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
    query: z.string().min(1, { message: 'What would you like to change?' }),
    simulator_id: z.number().int().positive({ message: 'Select simulator' }),
    track_id: z.number().int().positive({ message: 'Select track' }),
    car_id: z.number().int().positive({ message: 'Select car' }),
    setup_type: z.string().min(1, { message: 'Type is required' }),
    setup_data: z.instanceof(File, { message: 'Setup file is required' }),
}));

const form = useForm({
    validationSchema: formSchema
});

const setup = null;

const onSubmit = form.handleSubmit(async (values) =>
{
    const formData = new FormData();
    formData.append('query', values.query);
    formData.append('simulator_id', values.simulator_id);
    formData.append('track_id', values.track_id);
    formData.append('car_id', values.car_id);
    formData.append('setup_type', values.setup_type);
    formData.append('setup_data', values.setup_data);

    try {
        const response = await axios.post(route('api.setups.generate'), formData);
        setup.value = response.data;
        toast.success('Setup generated successfully');
    } catch (error) {
        toast.error('Failed to generate setup');
        console.error(error);
    }
})
</script>

<template>

    <Head title="Race Engineer" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="max-w-3xl mx-auto py-10 px-4">
                    <form @submit="onSubmit" class="flex flex-col space-y-4">
                        <FormField name="query" v-slot="{ componentField }">
                            <FormItem v-auto-animate>
                                <FormLabel>Query</FormLabel>
                                <FormControl>
                                    <Input v-bind="componentField" placeholder="e.g. 'Better front grip' or 'More stable rear'" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField name="simulator_id" v-slot="{ componentField }">
                            <FormItem v-auto-animate>
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
                            <FormItem v-auto-animate>
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
                            <FormItem v-auto-animate>
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
                            <FormItem v-auto-animate>
                                <FormLabel>Setup Type</FormLabel>
                                <FormControl>
                                    <Input v-bind="componentField" placeholder="e.g. Qualifying, Race" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField name="setup_data" v-slot="{ handleChange }">
                            <FormItem v-auto-animate>
                                <FormLabel>Setup File</FormLabel>
                                <FormControl>
                                    <Input type="file" id="setup_data" accept=".json" @input="(e) => { handleChange(e); form.setup_data = (e.target.files?.[0]!) }" class="file:mr-4 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
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
