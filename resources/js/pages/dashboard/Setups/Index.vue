<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem, type User } from "@/types";
import { Head, Link } from "@inertiajs/vue3";
import { Tabs, TabsTrigger, TabsList, TabsContent } from "@/components/ui/tabs";
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Clock, TrendingUp, Users, Trophy, Plus } from 'lucide-vue-next';
import { useInitials } from '@/composables/useInitials';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Setups",
        href: "/dashboard/setups",
    },
];

const props = defineProps<{
    setups: Array<{
        id: number;
        uuid: string;
        name: string;
        lap_time_ms: number;
        user: {
            name: string;
            avatar: string;
        };
        car: {
            name: string;
        };
        track: {
            name: string;
        };
    }>,
    user: User,
}>();

const formatLapTime = (timestamp: number) =>
{
    const minutes = Math.floor(timestamp / 60000);
    const seconds = Math.floor((timestamp % 60000) / 1000);
    const milliseconds = timestamp % 1000;

    const paddedSeconds = seconds.toString().padStart(2, '0');
    const paddedMilliseconds = milliseconds.toString().padStart(3, '0');

    return `${minutes}:${paddedSeconds}.${paddedMilliseconds}`;
}

const { getInitials } = useInitials();
</script>

<template>

    <Head title="My Setups" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <Tabs defaultValue="mysetups" class="space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <TabsList>
                            <TabsTrigger value="mysetups">My Setups</TabsTrigger>
                        </TabsList>
                        <Link :href="route('dashboard.setups.create')">
                        <Button>
                            <Plus class="h-4 w-4 mr-2" />
                            New Setup
                        </Button>
                        </Link>
                    </div>
                    <TabsContent value="mysetups" class="space-y-4">

                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <Card v-for="setup in props.setups" :key="setup.id" class="hover:border-red-600 transition-colors rounded-lg">
                                <CardHeader>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
                                                <AvatarImage :src="setup.user.avatar" :alt="setup.user.name" />
                                                <AvatarFallback class="rounded-lg text-black dark:text-white">
                                                    {{ getInitials(setup.user.name) }}
                                                </AvatarFallback>
                                            </Avatar>
                                            <div>
                                                <p class="text-sm font-medium">{{ setup.user.name }}</p>
                                                <p class="text-xs text-gray-500">2 days ago</p>
                                            </div>
                                        </div>
                                        <Button variant="ghost" size="icon">
                                            <Trophy class="h-4 w-4" />
                                        </Button>
                                    </div>
                                    <CardTitle class="mt-4">{{ setup.name }}</CardTitle>
                                    <p class="text-sm text-gray-500">
                                        {{ setup.car.name }} at {{ setup.track.name }}
                                    </p>
                                </CardHeader>
                                <CardContent>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="flex items-center space-x-2">
                                            <Clock class="h-4 w-4 text-gray-500" />
                                            <div>
                                                <p class="text-xs text-gray-500">Best Lap</p>
                                                <p class="text-sm font-medium">{{ formatLapTime(setup.lap_time_ms) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <TrendingUp class="h-4 w-4 text-gray-500" />
                                            <div>
                                                <p class="text-xs text-gray-500">Downloads</p>
                                                <p class="text-sm font-medium">1.2k</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <Users class="h-4 w-4 text-gray-500" />
                                            <div>
                                                <p class="text-xs text-gray-500">Users</p>
                                                <p class="text-sm font-medium">856</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end space-x-2">
                                        <Link :href="route('dashboard.setups.view', { setup: setup.uuid })">
                                        <Button variant="outline" size="sm">
                                            View Details
                                        </Button>
                                        </Link>
                                        <Button size="sm" class="bg-red-600 hover:bg-red-700">
                                            Download
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </AppLayout>
</template>
