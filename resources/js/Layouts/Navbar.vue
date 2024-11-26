<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

import { ExperimentOutlined, AppstoreOutlined, TeamOutlined, SolutionOutlined, UsergroupAddOutlined, ProjectOutlined } from '@ant-design/icons-vue';

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const navigationLinks = [
    { name: 'Laboratorios', route: 'dashboard', icon: ExperimentOutlined },
    { name: 'Recursos', route: 'dashboard', icon: AppstoreOutlined },
    { name: 'Usuarios', route: 'dashboard', icon: TeamOutlined },
    { name: 'Asistencias', route: 'dashboard', icon: SolutionOutlined },
    { name: 'Miembros', route: 'dashboard', icon: UsergroupAddOutlined },
    { name: 'Proyectos', route: 'dashboard', icon: ProjectOutlined },
];
</script>

<template>
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex flex-col ">
                    <div class="shrink-0 flex items-center justify-around py-4">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block h-9 w-auto" />
                        </Link>

                        <!-- Settings and Teams -->
                        <div class="hidden sm:flex sm:items-center">
                            <div class="ms-3 relative">
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60" class="z-50">
                                    <template #trigger>
                                        <button class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                                            {{ $page.props.auth.user.current_team.name }}
                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">Team Settings</DropdownLink>
                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">Create New Team</DropdownLink>
                                        <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                            <form @submit.prevent="switchToTeam(team)">
                                                <DropdownLink as="button">{{ team.name }}</DropdownLink>
                                            </form>
                                        </template>
                                    </template>
                                </Dropdown>
                            </div>
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="flex items-center text-sm focus:outline-none">
                                            <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                                        <form method="POST" @submit.prevent="logout">
                                            <DropdownLink as="button">Log Out</DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="space-y-4 flex flex-col">
                        <NavLink
                            v-for="link in navigationLinks"
                            :key="link.route"
                            :href="route(link.route)"
                            :active="route().current(link.route)"
                            class="flex items-center space-x-2"
                        >
                            <component :is="link.icon" class="text-lg" />
                            <span>{{ link.name }}</span>
                        </NavLink>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</template>
