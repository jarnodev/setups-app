<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head, Link } from "@inertiajs/vue3";
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Button } from '@/components/ui/button';

const props = defineProps<{
    setup: {
        id: number;
        name: string;
        lap_time_ms: number;
        user: {
            name: string;
            avatar?: string;
        };
        simulator: {
            name: string;
        },
        car: {
            name: string;
        };
        track: {
            name: string;
        };
        setup_data: any;
        lap_time_recorded_at: string | number | Date;
        created_at: string | number | Date;
        updated_at: string | number | Date;
    }
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "View Setup",
        href: "/dashboard/setups/" + props.setup.id,
    },
];

const formatLapTime = (timestamp: number) =>
{
    const minutes = Math.floor(timestamp / 60000);
    const seconds = Math.floor((timestamp % 60000) / 1000);
    const milliseconds = timestamp % 1000;

    const paddedSeconds = seconds.toString().padStart(2, '0');
    const paddedMilliseconds = milliseconds.toString().padStart(3, '0');

    return `${minutes}:${paddedSeconds}.${paddedMilliseconds}`;
}
</script>

<template>

    <Head title="My Setups" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-2xl">
                            {{ setup.car.name }} @ {{ setup.track.name }}
                        </CardTitle>
                        <div class="text-xs text-muted-foreground">
                            {{ setup.simulator.name }} &middot; {{ new Date(setup.created_at).toISOString().slice(0, 10) }}
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-2">
                        <div>
                            <strong>Simulator:</strong> {{ setup.simulator.name }}
                        </div>
                        <div>
                            <strong>Car:</strong> {{ setup.car.name }}
                        </div>
                        <div>
                            <strong>Track:</strong> {{ setup.track.name }}
                        </div>
                        <div>
                            <strong>Lap Time:</strong> {{ formatLapTime(setup.lap_time_ms) }}
                        </div>
                        <div>
                            <strong>Recorded At:</strong> {{ new Date(setup.lap_time_recorded_at).toISOString().slice(0, 10) }}
                        </div>
                        <div>
                            <strong>Created:</strong> {{ new Date(setup.created_at).toISOString().slice(0, 10) }}
                        </div>
                        <div>
                            <strong>Last Updated:</strong> {{ new Date(setup.updated_at).toISOString().slice(0, 10) }}
                        </div>
                        <details>
                            <summary class="cursor-pointer">Raw Setup Data</summary>
                            <pre class="bg-muted p-2 rounded text-xs overflow-x-auto">{{ setup.setup_data }}</pre>
                        </details>
                    </CardContent>
                </Card>
                <Link :href="route('dashboard.setups.index')">
                <Button class="mt-4" variant="outline">
                    Back to Setups
                </Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>