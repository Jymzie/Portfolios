<template>
<v-app>
    <v-navigation-drawer v-model="drawer" clipped app touchless mobile-breakpoint="0">
        <v-list dense>
            <v-subheader>SYSTEM PREVIEWS:</v-subheader>
            <v-list-item v-for="(item, i) in items" :key="i" :to="item.to">
                <v-list-item-icon>
                    <v-icon>{{ item.icon}} </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{ item.text}} </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-app-bar app clipped-left style="z-index: 99;">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <img src="images/jlogo.webp" style="border-radius: 10px;height: 50px;cursor: pointer;" @click="$router.push('/')"/>
       <v-toolbar-title @click="$router.push('/')" style="position: absolute; left:83px; display: inline-block;font-style: italic;text-shadow: 0px 0px 4px #FFFFFF;width: 210px; cursor: pointer;">'s Portfolio</v-toolbar-title>
    </v-app-bar>
    <v-main class="ma-2">
        <router-view style="min-width:400px"></router-view>
    </v-main>
</v-app>
</template>

<script>
export default {
    data: () => ({
        drawer: null,
        items: [{
                text: 'Nailpitch',
                icon: 'mdi-camera-iris',
                to: 'View'
            },
            {
                text: 'Balcony Handrail',
                icon: 'mdi-check',
                to: 'Plan'
            },
            {
                text: 'AccessManager',
                icon: 'mdi-lock',
                to: 'AccessManager'
            }
        ]
    }),
}
</script>
