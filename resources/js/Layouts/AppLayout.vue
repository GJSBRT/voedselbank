<script setup>
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Head, Link} from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { hasPermission } from '@/utils';

defineProps({
    title: String,
    breadcrumbs: Array,
});

const showingNavigationDropdown = ref(false);
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title"/>

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto"/>
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:flex sm:ml-4">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>

                                <NavLink :href="route('customers.index')" :active="route().current('customers.*')">
                                    Klanten
                                </NavLink>

                                <NavLink v-if="hasPermission('food-packages:read')" :href="route('food-packages.index')" :active="route().current('food-packages.*')">
                                    Voedsel Pakketten
                                </NavLink>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <Dropdown align="right" width="48" v-if="hasPermission('suppliers:read') || hasPermission('deliveries:read')">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                Magazijn

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink v-if="hasPermission('suppliers:read')" :href="route('suppliers.index')">
                                            Leveranciers
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"/>

                                        <DropdownLink v-if="hasPermission('deliveries:read')" :href="route('deliveries.index')">
                                            Leveringen
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <Dropdown align="right" width="48" v-if="hasPermission('products:read') || hasPermission('categories:read')">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                Producten

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink v-if="hasPermission('products:read')" :href="route('products.index')">
                                            Producten
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"/>

                                        <DropdownLink v-if="hasPermission('categories:read')" :href="route('categories.index')">
                                            Categorieën
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <Dropdown align="right" width="48" v-if="hasPermission('users:read') || hasPermission('roles:read')">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                Beheer

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink v-if="hasPermission('users:read')" :href="route('users.index')">
                                            Medewerkers
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"/>

                                        <DropdownLink v-if="hasPermission('roles:read')" :href="route('roles.index')">
                                            Rollen
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.first_name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Account
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"/>

                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Uitloggen
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('food-packages:read')" :href="route('food-packages.index')" :active="route().current('food-packages.*')">
                            Voedselpakketten
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('categories:read')" :href="route('categories.index')" :active="route().current('categories.index')">
                            Categorieën
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('suppliers:read')" :href="route('suppliers.index')" :active="route().current('supplier.*')">
                            Leveranciers
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('deliveries:read')" :href="route('deliveries.index')" :active="route().current('delivery.*')">
                            Leveringen
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('customers:read')" :href="route('customers.index')" :active="route().current('customers.*')">
                            Klanten
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('users:read')" :href="route('users.index')" :active="route().current('users.*')">
                            Medewerkers
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="hasPermission('roles:read')" :href="route('roles.index')" :active="route().current('roles.*')">
                            Rollen
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('quantity-products.index')" :active="route().current('quantity-products.index')">
                            Voorraad Producten
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('products.index')" :active="route().current('products.index')">
                            Producten
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.user.first_name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                               :href="route('api-tokens.index')"
                                               :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ breadcrumbs[breadcrumbs.length -1].title }}
                        </h2>

                        <div class="flex text-yellow-500 text-sm">
                            <Link v-for="(breadcrumb, key) of breadcrumbs" :href="breadcrumb.href" class="flex flex-row mb-4 m-1">
                                {{ breadcrumb.title }}
                                <p v-if="key != breadcrumbs.length -1" :class="key != breadcrumbs.length && 'ml-1'"> > </p>
                            </Link>
                        </div>
                    </div>
                    <slot name="header"/>
                </div>

            </header>

            <Banner/>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
