<template>
    <v-list v-model:opened="menuOpen" nav density="compact">
        <v-list-subheader>Menu</v-list-subheader>
        <template v-for="(menu, index) in items" :key="index">
            <template v-if="menu.group == null">
                <v-list-item
                    :prepend-icon="menu.icon"
                    :title="menu.title"
                    color="primary"
                    :class="
                        router.page.url == menu.to
                            ? 'v-list-item--active text-primary'
                            : ''
                    "
                    @click="router.get(menu.to)"
                />
            </template>
            <template v-else>
                <v-list-group :value="menu.to">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-icon="menu.icon"
                            :title="menu.title"
                            color="primary"
                        ></v-list-item>
                    </template>
                    <template v-for="submenu in menu.group">
                        <template v-if="submenu.group == null">
                            <v-list-item
                                :title="submenu.title"
                                color="primary"
                                :class="
                                    router.page.url == submenu.to
                                        ? 'v-list-item--active text-primary'
                                        : ''
                                "
                                @click="router.get(submenu.to)"
                            >
                                <template #prepend>
                                    <v-icon class="ms-0 me-2" size="x-large"
                                        >mdi-circle-small
                                    </v-icon>
                                </template>
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-group :value="submenu.to">
                                <template v-slot:activator="{ props }">
                                    <v-list-item
                                        v-bind="props"
                                        :title="submenu.title"
                                        color="primary"
                                    >
                                        <template #prepend>
                                            <v-icon class="mr-2" size="x-large"
                                                >mdi-circle-small
                                            </v-icon>
                                        </template>
                                    </v-list-item>
                                </template>

                                <v-list-item
                                    v-for="(subsubmenu, k) in submenu.group"
                                    :key="k"
                                    :title="subsubmenu.title"
                                    :value="subsubmenu.value"
                                    color="primary"
                                    @click="goToPage(subsubmenu.to)"
                                    :class="
                                        subsubmenu.to == router.page.url
                                            ? 'v-list-item--active text-primary'
                                            : ''
                                    "
                                >
                                    <template #prepend>
                                        <v-icon class="ms-3 me-2" size="x-large"
                                            >mdi-circle-small
                                        </v-icon>
                                    </template>
                                </v-list-item>
                            </v-list-group>
                        </template>
                    </template>
                </v-list-group>
            </template>
        </template>
    </v-list>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    items: Array,
});

const goToPage = (to) => {
    router.get(to);
};

const menuOpen = ref([]);

const init = () => {
    let _menuOpen = [];
    props.items.forEach((item) => {
        if (item.group) {
            item.group.forEach((subItem) => {
                if (subItem.to === router.page.url) {
                    _menuOpen.push(item.to);
                }
                if (subItem.group) {
                    subItem.group.forEach((subSubItem) => {
                        if (subSubItem.to === router.page.url) {
                            _menuOpen.push(subItem.to);
                            _menuOpen.push(item.to);
                        }
                    });
                }
            });
        }
    });

    menuOpen.value = _menuOpen;
};

init();

</script>

<style scoped>
.v-list-group__items .v-list-item {
    padding-inline-start: 20px !important;
}
</style>
