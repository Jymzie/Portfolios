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
        <router-view style="min-width:400px" :notificationSystem="notificationSystem"></router-view>
    </v-main>
</v-app>
</template>

<script>
export default {
    data: () => ({
        drawer: null,
        items: [
            {
                text: 'Planning and Scheduling',
                icon: 'mdi-map',
                to: 'HPS'
            },
            {
                text: 'Nailpitch',
                icon: 'mdi-camera-iris',
                to: 'NPS'
            },
            {
                text: 'Balcony Handrail',
                icon: 'mdi-check',
                to: 'BHM'
            },
            {
                text: 'AccessManager',
                icon: 'mdi-lock',
                to: 'AccessManager'
            },
                {
                text: 'ID System',
                icon: 'mdi-account',
                to: 'ID'
            },
        ],
        notificationSystem: {
        options: {
          show: {
            theme: "dark",
            icon: "icon-person",
            position: "topCenter",
            progressBarColor: "rgb(0, 255, 184)",
            buttons: [
              [
                "<button>Ok</button>",
                function(instance, toast) {
                  alert("Hello world!");
                },
                true
              ],
              [
                "<button>Close</button>",
                function(instance, toast) {
                  instance.hide(
                    {
                      transitionOut: "fadeOutUp",
                      onClosing: function(instance, toast, closedBy) {
                        console.info("closedBy: " + closedBy);
                      }
                    },
                    toast,
                    "buttonName"
                  );
                }
              ]
            ],
            onOpening: function(instance, toast) {
              console.info("callback abriu!");
            },
            onClosing: function(instance, toast, closedBy) {
              console.info("closedBy: " + closedBy);
            }
          },
          ballon: {
            balloon: true,
            position: "bottomCenter"
          },
          info: {
            position: "bottomLeft"
          },
          success: {
            position: "bottomRight"
          },
          warning: {
            position: "topLeft"
          },
          error: {
            position: "topRight"
          },
          question: {
            timeout: 20000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: "question",
            zindex: 999,
            position: "center",
            buttons: [
              [
                "<button><b>YES</b></button>",
                function(instance, toast) {
                  instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                },
                true
              ],
              [
                "<button>NO</button>",
                function(instance, toast) {
                  instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                }
              ]
            ],
            onClosing: function(instance, toast, closedBy) {
              console.info("Closing | closedBy: " + closedBy);
            },
            onClosed: function(instance, toast, closedBy) {
              console.info("Closed | closedBy: " + closedBy);
            }
          }
        }
      }
    }),
}
</script>
