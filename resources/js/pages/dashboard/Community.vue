<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Tabs, TabsTrigger, TabsList, TabsContent } from "@/components/ui/tabs";
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Community',
        href: '/dashboard/community',
    },
];
</script>

<template>

    <Head title="Community" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1">
                <Tabs defaultValue="popular" class="space-y-4">
                    <TabsList>
                        <TabsTrigger value="popular">Popular</TabsTrigger>
                    </TabsList>
                    <TabsContent value="popular" class="space-y-4">
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </AppLayout>
</template>
