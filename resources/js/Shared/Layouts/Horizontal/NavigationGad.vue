<template>
    <header id="page-topbar" style="background-color: #503c75;">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box horizontal-logo">
                        <div class="d-flex" style="margin-top: 10px;">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2rem;width:2rem;">
                                <img src="@assets/images/logo-sm.png" alt="" style="width: 40px; height: auto; margin-top: 3px;">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 ms-0 mt-2 fs-14 fw-semibold text-uppercase text-white" style="font-size: 10.7px"> DEPARTMENT OF SCIENCE AND TECHNOLOGY - Regional Standards and Testing Laboratories</h5>
                                <p class="text-white fs-11 float-start"><span class="fw-semibold">One<span class="text-info">DOST</span>4U</span> : <span class="text-white">Gender and Development</span></p>
                            </div>
                        </div>
                    </div>

                    <BButton variant="white" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger  material-shadow-none" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </BButton>
                </div>

                <div class="d-flex align-items-center">
                    

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <BButton type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle material-shadow-none" data-toggle="fullscreen" @click="initFullScreen">
                            <i class="bx bx-fullscreen fs-22"></i>
                        </BButton>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <BButton type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle light-dark-mode material-shadow-none" @click="toggleDarkMode">
                            <i class="bx bx-moon fs-22"></i>
                        </BButton>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script setup> 
import { router } from '@inertiajs/vue3';
import { layoutMethods } from "@/Shared/State/helpers";
const logout = () => {
  router.post('/logout');
}; 
</script>
<script>
import simplebar from "simplebar-vue";
export default {
    components: { simplebar },
    data() {
        return {
        text: null,
        value: null,
        myVar: 1,
        };
    },
    mounted() {
        document.addEventListener("scroll", function () {
        var pageTopbar = document.getElementById("page-topbar");
        if (pageTopbar) {
            document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add(
            "topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
        }
        });
        if (document.getElementById("topnav-hamburger-icon"))
            document.getElementById("topnav-hamburger-icon").addEventListener("click", this.toggleHamburgerMenu);

    },
    methods: {
        ...layoutMethods,
        toggleHamburgerMenu() {
            var windowSize = document.documentElement.clientWidth;
            let layoutType = document.documentElement.getAttribute("data-layout");

            document.documentElement.setAttribute("data-sidebar-visibility", "show");
            let visiblilityType = document.documentElement.getAttribute("data-sidebar-visibility");

            if (windowSize > 767)
                document.querySelector(".hamburger-icon").classList.toggle("open");

            //For collapse horizontal menu
            if (
                document.documentElement.getAttribute("data-layout") === "horizontal"
            ) {
                document.body.classList.contains("menu") ?
                document.body.classList.remove("menu") :
                document.body.classList.add("menu");
            }

            //For collapse vertical menu

            if (visiblilityType === "show" && (layoutType === "vertical" || layoutType === "semibox")) {
                if (windowSize < 1025 && windowSize > 767) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                    document.documentElement.setAttribute("data-sidebar-size", "") :
                    document.documentElement.setAttribute("data-sidebar-size", "sm");
                } else if (windowSize > 1025) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                    document.documentElement.setAttribute("data-sidebar-size", "sm") :
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
                } else if (windowSize <= 767) {
                document.body.classList.add("vertical-sidebar-enable");
                document.documentElement.setAttribute("data-sidebar-size", "lg");
                }
            }

            //Two column menu
            if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
                document.body.classList.contains("twocolumn-panel") ?
                document.body.classList.remove("twocolumn-panel") :
                document.body.classList.add("twocolumn-panel");
            }
            },
        toggleMenu() {
        this.$parent.toggleMenu();
        },
        toggleRightSidebar() {
        this.$parent.toggleRightSidebar();
        },
        initFullScreen() {
        document.body.classList.toggle("fullscreen-enable");
        if (
            !document.fullscreenElement &&
            /* alternative standard method */
            !document.mozFullScreenElement &&
            !document.webkitFullscreenElement
        ) {
            // current working methods
            if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(
                Element.ALLOW_KEYBOARD_INPUT
            );
            }
        } else {
            if (document.cancelFullScreen) {
            document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
            }
        }
        },

        toggleDarkMode() {

        if (document.documentElement.getAttribute("data-bs-theme") == "dark") {
            document.documentElement.setAttribute("data-bs-theme", "light");
        } else {
            document.documentElement.setAttribute("data-bs-theme", "dark");
        }

        const mode = document.documentElement.getAttribute("data-bs-theme")
        this.changeMode({
            mode: mode,
        });
        },
        setDefaultImage(event) {
        event.target.src = '/images/avatars/avatar.jpg';
        },
         async logout() {
            try {
                await axios.get('/logout')
                window.location.href = '/login' // redirect manually after logout
            } catch (error) {
                console.error('Logout failed:', error)
            }
        },
    }
}
</script>