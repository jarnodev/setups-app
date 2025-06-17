<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";
import { Tabs, TabsTrigger, TabsList, TabsContent } from "@/components/ui/tabs";
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Setups",
        href: "/dashboard/setups",
    },
];
</script>

<template>

    <Head title="My Setups" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <Tabs defaultValue="mysetups" class="space-y-4">
                    <TabsList>
                        <TabsTrigger value="mysetups">My Setups</TabsTrigger>
                    </TabsList>

                    <TabsContent value="mysetups" class="space-y-4">
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <Card v-for="setup in setups" :key="setup.id" class="hover:border-red-600 transition-colors">
                                <CardHeader>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <Avatar class="h-8 w-8">
                                                <AvatarImage src={setup.user.image} alt={setup.user.name} />
                                                <AvatarFallback>{setup.user.name?.charAt(0) || setup.user.email?.charAt(0) || "U"}</AvatarFallback>
                                            </Avatar>
                                            <div>
                                                <p class="text-sm font-medium">{setup.user.name}</p>
                                                <p class="text-xs text-gray-500">2 days ago</p>
                                            </div>
                                        </div>
                                        <Button variant="ghost" size="icon">
                                            <Trophy class="h-4 w-4" />
                                        </Button>
                                    </div>
                                    <CardTitle class="mt-4">{setup.name}</CardTitle>
                                    <p class="text-sm text-gray-500">
                                        {setup.car.name} at {setup.track.name}
                                    </p>
                                </CardHeader>
                                <CardContent>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="flex items-center space-x-2">
                                            <Clock class="h-4 w-4 text-gray-500" />
                                            <div>
                                                <p class="text-xs text-gray-500">Best Lap</p>
                                                <p class="text-sm font-medium">1:23.456</p>
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
                                        <Button variant="outline" size="sm">
                                            View Details
                                        </Button>
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
