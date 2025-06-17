<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Check } from "lucide-vue-next";
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <main class="min-h-screen bg-background">
        <div class="relative h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-background/50 to-background z-10" />
            <div class="absolute inset-0 bg-[url('/racing-bg.jpg')] bg-cover bg-center" />

            <div class="relative z-20 text-center px-4 max-w-4xl mx-auto">
                <h1 class="text-6xl mb-6 bg-clip-text text-transparent bg-gradient-to-r from-primary to-primary/80"><strong>Setups</strong>.app</h1>
                <p class="text-xl text-muted-foreground mb-8">
                    Your AI-powered sim racing setup assistant. Get competitive setups in seconds.
                </p>
                <div class="flex gap-4 justify-center">
                    <Link :href="route('dashboard')">
                        <Button size="lg" class="text-lg px-8">
                            Get Started
                        </Button>
                    </Link>
                    <Link href="#features">
                        <Button size="lg" variant="outline" class="text-lg px-8">
                            Learn More
                        </Button>
                    </Link>
                </div>
            </div>
        </div>
        <section id="features" class="py-20 bg-muted/50 border-b">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl text-center mb-12 tracking-tight">Why <strong>Setups</strong>.app?</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-card p-8 rounded-xl shadow flex flex-col items-center text-center border border-muted/40">
                        <div class="mb-4 flex items-center justify-center w-10 h-10 rounded-full bg-primary/10">
                            <Check class="w-5 h-5 text-primary" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Lightning Fast</h3>
                        <p class="text-muted-foreground text-sm">Get competitive setups in seconds, not hours.</p>
                    </div>
                    <div class="bg-white dark:bg-card p-8 rounded-xl shadow flex flex-col items-center text-center border border-muted/40">
                        <div class="mb-4 flex items-center justify-center w-10 h-10 rounded-full bg-primary/10">
                            <Check class="w-5 h-5 text-primary" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">AI-Powered</h3>
                        <p class="text-muted-foreground text-sm">Advanced AI that understands racing dynamics.</p>
                    </div>
                    <div class="bg-white dark:bg-card p-8 rounded-xl shadow flex flex-col items-center text-center border border-muted/40">
                        <div class="mb-4 flex items-center justify-center w-10 h-10 rounded-full bg-primary/10">
                            <Check class="w-5 h-5 text-primary" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Secure & Private</h3>
                        <p class="text-muted-foreground text-sm">Your setups and data are always protected.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="pricing" class="py-20 bg-background border-b">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-10 tracking-tight">Pricing</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-card p-8 rounded-xl flex flex-col items-center border border-muted/40 shadow-sm transition hover:shadow-lg">
                        <h3 class="text-lg font-semibold mb-1">Free</h3>
                        <div class="text-3xl font-bold mb-1">$0</div>
                        <div class="text-xs text-muted-foreground mb-4">per month</div>
                        <ul class="text-xs mb-6 space-y-2 text-left w-full">
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />3 AI setups/week
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Community downloads
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Basic search
                            </li>
                        </ul>
                        <Button class="w-full text-xs mt-auto" variant="outline">
                            <Link :href="route('dashboard')">Get Started</Link>
                        </Button>
                    </div>
                    <div class="bg-primary/5 border-2 border-primary p-8 rounded-xl flex flex-col items-center scale-105 shadow-lg transition hover:shadow-xl">
                        <h3 class="text-lg font-semibold mb-1 text-primary">Pro</h3>
                        <div class="text-3xl font-bold mb-1 text-primary">$9</div>
                        <div class="text-xs text-muted-foreground mb-4">per month</div>
                        <ul class="text-xs mb-6 space-y-2 text-left w-full">
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Unlimited AI setups
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Advanced search & filters
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Priority support
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Early feature access
                            </li>
                        </ul>
                        <Button class="w-full text-xs mt-auto" variant="default">
                            <Link :href="route('dashboard')">Start Pro</Link>
                        </Button>
                    </div>
                    <div class="bg-white dark:bg-card p-8 rounded-xl flex flex-col items-center border border-muted/40 shadow-sm transition hover:shadow-lg">
                        <h3 class="text-lg font-semibold mb-1">Team</h3>
                        <div class="text-3xl font-bold mb-1">$29</div>
                        <div class="text-xs text-muted-foreground mb-4">per month</div>
                        <ul class="text-xs mb-6 space-y-2 text-left w-full">
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Everything in Pro
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                10 team members
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Shared library
                            </li>
                            <li class="flex items-center gap-2">
                                <Check class="w-4 h-4 text-primary" />
                                Priority onboarding
                            </li>
                        </ul>
                        <Button class="w-full text-xs mt-auto" variant="outline">
                            <Link :href="route('dashboard')">Contact Sales</Link>
                        </Button>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-primary/5 border-t">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4 tracking-tight">Ready to improve your lap times?</h2>
                <p class="text-xl text-muted-foreground mb-8">Join thousands of sim racers who trust <strong>Setups</strong>.app for their setups.</p>
                <Link :href="route('dashboard')">
                    <Button size="lg" class="text-lg px-8">
                        Start Racing Now
                    </Button>
                </Link>
            </div>
        </section>
    </main>
</template>
