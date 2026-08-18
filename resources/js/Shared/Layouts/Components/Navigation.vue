<template>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box horizontal-logo">
                        <Link href="/" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="@assets/images/logo-sm.png" alt="" height="22" />
                            </span>
                            <span class="logo-lg">
                                <img src="@assets/images/logo-dark.png" alt="" height="17" />
                            </span>
                        </Link>
                        <Link href="/" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="@assets/images/logo-sm.png" alt="" height="22" />
                            </span>
                            <span class="logo-lg">
                                <img src="@assets/images/logo-light.png" alt="" height="17" />
                            </span>
                        </Link>
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
                        <a :href="`/accomplishments`" target="_blank">
                            <BButton type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle">
                                <i class="ri-focus-3-line fs-22"></i>
                            </BButton>
                        </a>
                    </div>
                    <BDropdown class="dropdown" variant="ghost-secondary" dropstart :offset="{ alignmentAxis: 57, crossAxis: 0, mainAxis: -42 }" toggle-class="btn-icon btn-topbar rounded-circle mode-layout ms-1 material-shadow-none" no-caret menu-class="p-0 dropdown-menu-end">
                        <template #button-content>
                            <i class="bx bx-category-alt fs-22"></i>
                        </template>
                        <div
                            class="p-3 border-top-0 dropdown-head border-start-0 border-end-0 border-dashed border dropdown-menu-lg">
                            <BRow class="align-items-center">
                                <BCol>
                                    <h6 class="m-0 fw-semibold fs-15">Insights</h6>
                                </BCol>
                                <BCol cols="auto">
                                    <BLink href="#!" class="btn btn-sm btn-soft-info">
                                        View All
                                        <i class="ri-arrow-right-s-line align-middle"></i>
                                    </BLink>
                                </BCol>
                            </BRow>
                        </div>

                        <div class="p-2">
                            <BRow class="g-0">
                                <BCol>
                                    <BLink class="dropdown-icon-item" @click="openInNewTab('/insights/performance')">
                                        <img src="@assets/images/apps/customer.png" alt="customer" />
                                        <span>Performance</span>
                                    </BLink>
                                </BCol>
                                <BCol>
                                    <BLink class="dropdown-icon-item" @click="openInNewTab('/insights/customers')">
                                        <img src="@assets/images/apps/customer.png" alt="customer" />
                                        <span>Customers</span>
                                    </BLink>
                                </BCol>
                                <BCol>
                                    <BLink class="dropdown-icon-item" @click="openInNewTab('/insights/laboratories')">
                                        <img src="@assets/images/apps/laboratory.png" alt="laboratoryt" />
                                        <span>Laboratories</span>
                                    </BLink>
                                </BCol>
                               
                            </BRow>

                            <BRow class="g-0">
                                 <BCol>
                                    <BLink class="dropdown-icon-item" @click="openInNewTab('/insights/payments')">
                                        <img src="@assets/images/apps/payment.png" alt="payment" />
                                        <span>Payments</span>
                                    </BLink>
                                </BCol>
                                 <BCol>
                                    <BLink class="dropdown-icon-item" @click="openInNewTab('/insights/laboratories')">
                                        <img src="@assets/images/apps/laboratory.png" alt="laboratoryt" />
                                        <span>Testservices</span>
                                    </BLink>
                                </BCol>
                                <!-- <BCol>
                                    <BLink class="dropdown-icon-item" href="#!">
                                        <img src="@assets/images/brands/mail_chimp.png" alt="mail_chimp" />
                                        <span>Mail Chimp</span>
                                    </BLink>
                                </BCol>
                                <BCol>
                                    <BLink class="dropdown-icon-item" href="#!">
                                        <img src="@assets/images/brands/slack.png" alt="slack" />
                                        <span>Slack</span>
                                    </BLink>
                                </BCol> -->
                            </BRow>
                        </div>
                    </BDropdown>

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

                    <BDropdown variant="ghost-dark" dropstart class="ms-1 dropdown"
            :offset="{ alignmentAxis: 57, crossAxis: 0, mainAxis: -42 }"
            toggle-class="btn-icon btn-topbar rounded-circle arrow-none" id="page-header-notifications-dropdown"
            menu-class="dropdown-menu-lg notification-menu-wide dropdown-menu-end p-0" auto-close="outside">
            <template #button-content>
              <i class='bx bx-bell fs-22'></i>
              <span v-if="totalNotifications > 0" class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><span
                  class="notification-badge">{{ totalNotifications }}</span><span class="visually-hidden">unread
                  messages
                </span>
              </span>
            </template>
            <div class="dropdown-head bg-primary bg-pattern rounded-top dropdown-menu-lg notification-menu-wide">
              <div class="p-3">
                <BRow class="align-items-center">
                  <BCol>
                    <h6 class="m-0 fs-16 fw-semibold text-white">
                      Notifications
                    </h6>
                  </BCol>
                  <BCol cols="auto" class="dropdown-tabs">
                    <BBadge variant="light-subtle" class="bg-light-subtle text-body fs-13"> {{ totalNotifications }} New</BBadge>
                  </BCol>
                </BRow>
              </div>
            </div>
            <BTabs nav-class="dropdown-tabs nav-tab-custom bg-primary px-2 pt-2">
              <BTab v-if="['Customer Relation Officer', 'Technical Manager'].some(role => $page.props.roles.includes(role))" :title="'Requests' + (notifications.requests?.count ? ' (' + notifications.requests.count + ')' : '')" class="tab-pane fade py-2 ps-2" id="requests-tab" role="tabpanel"
                aria-labelledby="requests-tab">
                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                  <template v-if="notifications.requests?.items?.length">
                    <div v-for="(item, idx) in notifications.requests.items" :key="idx" class="text-reset notification-item d-block dropdown-item position-relative">
                      <div class="d-flex">
                        <img :src="item.avatar" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic" />
                        <div class="flex-grow-1">
                          <Link :href="`/requests?open=${item.reference}`" class="stretched-link">
                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">{{ item.name }}</h6>
                          </Link>
                          <div class="fs-12 text-muted">
                            <p class="mb-1">{{ item.content }}</p>
                          </div>
                          <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                            <span><i class="mdi mdi-clock-outline"></i> {{ item.time }}</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </template>
                  <div v-else class="text-center pt-4 pb-3">
                    <div class="avatar-md mx-auto mb-3">
                      <div class="avatar-title bg-info-subtle rounded-circle text-info">
                        <i class="ri-file-edit-fill fs-24"></i>
                      </div>
                    </div>
                    <h6 class="fs-15 fw-semibold lh-base mb-0">No pending update requests</h6>
                  </div>
                  <div class="my-3 text-center">
                    <Link href="/requests" class="btn btn-sm btn-soft-info">
                      View Requests
                      <i class="ri-arrow-right-line align-middle"></i>
                    </Link>
                  </div>
                </simplebar>
              </BTab>

              <BTab v-if="['Customer Relation Officer', 'Technical Manager', 'Laboratory Analyst', 'Calibration Officer','Laboratory Head'].some(role => $page.props.roles.includes(role))" :title="'For Signatures' + (notifications.signing?.count ? ' (' + notifications.signing.count + ')' : '')" class="tab-pane fade py-2 ps-2" id="signing-tab" role="tabpanel"
                aria-labelledby="signing-tab">
                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                  <template v-if="notifications.signing?.items?.length">
                    <div v-for="(item, idx) in notifications.signing.items" :key="idx" class="border text-reset notification-item d-block dropdown-item position-relative">
                      <div class="d-flex">
                        <img :src="item.avatar" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic" />
                        <div class="flex-grow-1">
                          <Link :href="`/signing?open=${item.reference}`" class="stretched-link">
                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">{{ item.name }}</h6>
                          </Link>
                          <div class="fs-12 text-muted">
                            <p class="mb-1">Report for <b>{{ item.sample_code }}</b> is awaiting your signature.</p>
                          </div>
                          <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                            <span><i class="mdi mdi-clock-outline"></i> {{ item.time }}</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </template>
                  <div v-else class="text-center pt-4 pb-3">
                    <div class="avatar-md mx-auto mb-3">
                      <div class="avatar-title bg-warning-subtle rounded-circle text-warning">
                        <i class="ri-quill-pen-fill fs-24"></i>
                      </div>
                    </div>
                    <h6 class="fs-15 fw-semibold lh-base mb-0">No reports awaiting your signature</h6>
                  </div>
                  <div class="my-3 text-center">
                    <Link href="/signing" class="btn btn-sm btn-soft-warning">
                      View Signing
                      <i class="ri-arrow-right-line align-middle"></i>
                    </Link>
                  </div>
                </simplebar>
              </BTab>
            </BTabs>
          </BDropdown>

                    <BDropdown variant="link" class="ms-sm-3 header-item topbar-user" toggle-class="rounded-circle material-shadow-none" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -14, crossAxis: 0, mainAxis: 0 }">
                        <template #button-content>
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" :src="$page.props.user.data.avatar" @error="setDefaultImage($event)" :alt="$page.props.user.data.username">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $page.props.user.data.name }}</span>
                                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ $page.props.roles[0] }}</span>
                                </span>
                            </span>
                        </template>
                        <h6 class="dropdown-header">Welcome {{ $page.props.user.data.username }}!</h6>
                        <Link class="dropdown-item" href="/profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Profile</span>
                        </Link>
                        <!-- <div class="dropdown-divider"></div>
                        <Link class="dropdown-item" href="/chat">
                            <i class=" mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"> Messages</span>
                        </Link>
                        <Link class="dropdown-item" href="/apps/tasks-kanban">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"> Taskboard</span>
                        </Link>
                        <Link class="dropdown-item" href="/pages/faqs">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"> Help</span>
                        </Link> -->
                        <div class="dropdown-divider"></div>
                        <!-- <Link class="dropdown-item" href="/pages/profile-setting">
                            <BBadge variant="success-subtle" class="bg-success-subtle text-success mt-1 float-end">New</BBadge>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"> Settings</span>
                        </Link> -->
                        <!-- <Link class="dropdown-item" href="/confirm-password">
                            <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"> Lock screen</span>
                        </Link> -->

                        <form method="POST" @submit.prevent="logout" class="dropdown-item">
                            <BButton variant="none" type="submit" class="btn p-0"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Logout</BButton>
                        </form>
                    </BDropdown>
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
    computed: {
        notifications() {
            return this.$page.props.notifications || { requests: { count: 0, items: [] }, signing: { count: 0, items: [] } };
        },
        totalNotifications() {
            return (this.notifications.requests?.count || 0) + (this.notifications.signing?.count || 0);
        }
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
        openInNewTab(url) {
            window.open(url, '_blank');
        },
    }
}
</script>