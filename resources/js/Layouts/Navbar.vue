<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { ExperimentOutlined, AppstoreOutlined, TeamOutlined, SolutionOutlined, UsergroupAddOutlined, ProjectOutlined, DownOutlined } from '@ant-design/icons-vue';

import { Dropdown, MenuDivider, MenuItem, Menu  } from 'ant-design-vue';

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
    { name: 'Dashboard', route: 'dashboard.index', icon: TeamOutlined },
    { name: 'Denuncias', route: 'denuncias.index', icon: AppstoreOutlined },
    { name: 'Evaluaciones', route: 'usuarios.index', icon: SolutionOutlined },
    { name: 'Usuarios', route: 'usuarios.index', icon: TeamOutlined },
];
</script>

<template>
    <div class="flex z-50 shadow-sm">
        <aside class="w-64 bg-white dark:bg-gray-800 h-screen flex-col border-r border-gray-200 dark:border-gray-600 hidden sm:flex">
            <!-- Logo y Título -->
            <div class="flex items-center px-4 h-[73.5px] border-b border-gray-200 dark:border-gray-600 py-4">
                <Link :href="route('dashboard.index')" class="flex items-center space-x-4">
                    <ApplicationMark class="w-12 rounded-md" />
                    <div class="flex flex-col">
                        <h1 class="text-xs font-bold text-red-800 mb-0 dark:text-red-600">Gobierno del Perú</h1>
                        <p class="text-xs mb-0 dark:text-white">Contraloría General de la República</p>
                    </div>
                </Link>
            </div>

            <div class="flex flex-col justify-between h-full px-4">
                <!-- Lista de Enlaces -->
                <nav class="flex flex-col py-6 space-y-4 flex-1">
                    <NavLink
                        v-for="link in navigationLinks"
                        :key="link.route"
                        :href="route(link.route)"
                        :active="route().current(link.route)"
                        class="flex items-center space-x-2"
                    >
                        <!-- Icono -->
                        <component :is="link.icon" class="text-lg" />
                        <!-- Texto -->
                        <span>{{ link.name }}</span>
                    </NavLink>
                </nav>

                <!-- Dropdown con Ant Design -->
                <div class="flex justify-between items-center py-4">
                    <Dropdown>
                        <template #overlay>
                            <Menu>
                                <MenuItem>
                                    <Link v-if="$page.props.auth.user.current_team" :href="route('teams.show', $page.props.auth.user.current_team)">Configuración del equipo</Link>
                                </MenuItem>
                                <MenuItem v-if="$page.props.jetstream.canCreateTeams">
                                    <Link :href="route('teams.create')">Crear nuevo equipo</Link>
                                </MenuItem>
                                <MenuDivider />
                                <MenuItem v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <Button class="w-full text-left">{{ team.name }}</Button>
                                    </form>
                                </MenuItem>
                            </Menu>
                        </template>
                        <a class="ant-dropdown-link flex items-center text-sm leading-4 font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            {{ $page.props.auth.user.current_team ? $page.props.auth.user.current_team.name : 'Sin equipo' }}
                            <DownOutlined class="ml-2" />
                        </a>
                    </Dropdown>
                </div>
            </div>




            <!-- Opciones del usuario en la parte inferior -->
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-600">
                <p class="mb-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                    {{ $page.props.auth.user.name }}
                </p>
                <nav class="flex flex-col space-y-4">
                    <NavLink :href="route('profile.show')" :active="route().current('profile.show') ">
                        Mi perfil
                    </NavLink>
                    <form @submit.prevent="logout">
                        <NavLink as="button">Cerrar sesión</NavLink>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Responsive toggle -->
        <div class="sm:hidden fixed top-4 right-4 z-50">
            <button class="p-2 bg-gray-800 text-white rounded-full shadow-lg" @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg v-if="!showingNavigationDropdown" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg v-else class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Responsive Sidebar -->
        <div
            :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 sm:hidden"
            @click="showingNavigationDropdown = false"
        >
            <div class="w-64 h-full bg-white dark:bg-gray-800" @click.stop>
                <nav class="px-4 py-6">
                    <ResponsiveNavLink
                        v-for="link in navigationLinks"
                        :key="link.route"
                        :href="route(link.route)"
                        :active="route().current(link.route)"
                    >
                        <component :is="link.icon" class="text-lg me-2" />
                        {{ link.name }}
                    </ResponsiveNavLink>
                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">Perfil</ResponsiveNavLink>
                    <form @submit.prevent="logout">
                        <ResponsiveNavLink as="button">Cerrar sesión</ResponsiveNavLink>
                    </form>
                </nav>
            </div>
        </div>
    </div>
</template>





