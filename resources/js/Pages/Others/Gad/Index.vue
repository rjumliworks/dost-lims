<template>
    <div class="row g-4">
        <!-- Main Content Column -->
        <div class="col-lg-8">
            <!-- Announcement Header -->
            <div class="card bg-gradient-primary border-0 shadow-lg mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-md">
                                <div class="avatar-title bg-white bg-opacity-25 rounded-circle">
                                    <i class="bx bx-bell fs-22 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-white mb-1">Announcements & Updates</h5>
                                    <p class="text-white text-opacity-75 mb-0 small">Stay informed with the latest GAD news and events</p>
                                </div>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-2 mt-sm-0">
                                    <i class="bx bx-time me-1"></i> 3 New Updates
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Carousel Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                        <BCarousel 
                            class="carousel slide carousel-fade" 
                            ride="carousel" 
                            :interval="4000" 
                            controls 
                            indicators
                            style="height: 400px;"
                        >
                            <BCarouselSlide 
                                :img-src="Img1" 
                                class="carousel-item"
                                img-height="400"
                                img-width="1200"
                            >
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-30 rounded-3 p-4 mb-4">
                                    <div class="d-inline-block mb-3">
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="bx bx-star me-1"></i> FEATURED
                                        </span>
                                    </div>
                                    <h3 class="text-white fw-bold display-6">DOST-IX</h3>
                                    <p class="text-white fs-5 mb-3 opacity-75">
                                        Join us for the annual gathering of changemakers and advocates
                                    </p>
                                    <button class="btn btn-warning btn-lg rounded-pill px-4">
                                        <i class="bx bx-calendar me-2"></i> Register Now
                                    </button>
                                </div>
                            </BCarouselSlide>
                            
                            <BCarouselSlide 
                                :img-src="Img2"
                                img-height="400"
                                img-width="1200"
                            >
                                <div class="carousel-caption d-none d-md-block bg-primary bg-opacity-40 rounded-3 p-4 mb-4">
                                    <div class="d-inline-block mb-3">
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                            <i class="bx bx-time me-1"></i> UPCOMING
                                        </span>
                                    </div>
                                    <h3 class="text-white fw-bold">New Training Module Launch</h3>
                                    <p class="text-white fs-5 mb-3">
                                        GAD Capacity Development Program - Online enrollment now open
                                    </p>
                                    <button class="btn btn-info btn-lg rounded-pill px-4 text-white">
                                        <i class="bx bx-play-circle me-2"></i> Learn More
                                    </button>
                                </div>
                            </BCarouselSlide>
                            
                            <BCarouselSlide 
                                :img-src="Img3"
                                img-height="400"
                                img-width="1200"
                            >
                                <div class="carousel-caption d-none d-md-block bg-success bg-opacity-40 rounded-3 p-4 mb-4">
                                    <div class="d-inline-block mb-3">
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                            <i class="bx bx-trending-up me-1"></i> TRENDING
                                        </span>
                                    </div>
                                    <h3 class="text-white fw-bold">VAW Free Workplace Certification</h3>
                                    <p class="text-white fs-5 mb-3">
                                        150+ organizations already certified. Is yours next?
                                    </p>
                                    <button class="btn btn-success btn-lg rounded-pill px-4">
                                        <i class="bx bx-certification me-2"></i> Check Eligibility
                                    </button>
                                </div>
                            </BCarouselSlide>
                        </BCarousel>
                        
                        <!-- Carousel Overlay Stats -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-transparent d-none d-lg-block" style="z-index: 10;">
                            <div class="row g-3 text-white">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-show fs-24 me-2"></i>
                                        <div>
                                            <small>Total Views</small>
                                            <h6 class="mb-0 text-white">12.5K</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-share-alt fs-24 me-2"></i>
                                        <div>
                                            <small>Shares</small>
                                            <h6 class="mb-0 text-white">2.8K</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-comment fs-24 me-2"></i>
                                        <div>
                                            <small>Comments</small>
                                            <h6 class="mb-0 text-white">486</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-soft-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md bg-primary rounded-circle">
                                        <i class="bx bx-file fs-24 text-white avatar-title"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Total Resources</h6>
                                    <h3 class="mb-0 fw-bold">1,247</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-soft-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md bg-success rounded-circle">
                                        <i class="bx bx-download fs-24 text-white avatar-title"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Downloads</h6>
                                    <h3 class="mb-0 fw-bold">45.2K</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-soft-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md bg-info rounded-circle">
                                        <i class="bx bx-user fs-24 text-white avatar-title"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Active Users</h6>
                                    <h3 class="mb-0 fw-bold">3,891</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-semibold mb-0"><i class="bx bx-bolt text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary text-start d-flex align-items-center justify-content-between p-3">
                            <span><i class="bx bx-upload me-2"></i> Upload New Material</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <button class="btn btn-outline-success text-start d-flex align-items-center justify-content-between p-3">
                            <span><i class="bx bx-search me-2"></i> Search Resources</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <button class="btn btn-outline-info text-start d-flex align-items-center justify-content-between p-3">
                            <span><i class="bx bx-help-circle me-2"></i> Request Assistance</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-semibold mb-0"><i class="bx bx-history text-info me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item d-flex gap-3 mb-4">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-primary rounded-circle">
                                    <i class="bx bx-file text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">New document uploaded</h6>
                                <p class="text-muted small mb-0">RA 11313 Implementing Rules</p>
                                <span class="text-muted smaller">5 minutes ago</span>
                            </div>
                        </div>
                        <div class="timeline-item d-flex gap-3 mb-4">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-success rounded-circle">
                                    <i class="bx bx-download text-success"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">VAW Primer downloaded</h6>
                                <p class="text-muted small mb-0">By Maria Santos, PCW</p>
                                <span class="text-muted smaller">1 hour ago</span>
                            </div>
                        </div>
                        <div class="timeline-item d-flex gap-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-warning rounded-circle">
                                    <i class="bx bx-star text-warning"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">New announcement posted</h6>
                                <p class="text-muted small mb-0">GAD Summit 2025</p>
                                <span class="text-muted smaller">3 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Resource Card -->
            <div class="card bg-gradient-purple border-0 shadow-lg mt-4">
                <div class="card-body p-4">
                    <span class="badge bg-warning text-dark mb-3">FEATURED</span>
                    <h5 class="text-white fw-semibold mb-2">Safe Spaces Act</h5>
                    <p class="text-white-50 small mb-3">Comprehensive guide and downloadable resources</p>
                    <div class="d-flex align-items-center text-white mb-3">
                        <i class="bx bx-download me-2"></i>
                        <span class="small">2.5k downloads this week</span>
                    </div>
                    <button class="btn btn-light w-100 rounded-pill">
                        <i class="bx bx-right-arrow-alt me-2"></i> Access Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Img1 from "@assets/images/small/1.png";
import Img2 from "@assets/images/small/2.jpg";
import Img3 from "@assets/images/small/3.jpg";

export default {
    name: 'LandingPage',
    data() {
        return {
            Img1, 
            Img2, 
            Img3,
        };
    },
}
</script>

<style scoped>
/* Gradient backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-purple {
    background: linear-gradient(135deg, #6b21a5 0%, #a21caf 100%);
}

.bg-gradient-transparent {
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
}

/* Avatar sizes */
.avatar-md {
    height: 48px;
    width: 48px;
}

.avatar-title {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Background soft colors */
.bg-soft-primary {
    background-color: rgba(102, 126, 234, 0.1);
}

.bg-soft-success {
    background-color: rgba(40, 167, 69, 0.1);
}

.bg-soft-info {
    background-color: rgba(23, 162, 184, 0.1);
}

.bg-soft-warning {
    background-color: rgba(255, 193, 7, 0.1);
}

/* Carousel customization */
.carousel-caption {
    bottom: 3rem;
    left: 10%;
    right: 10%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.carousel-item {
    transition: transform 0.6s ease-in-out;
}

.carousel-item img {
    object-fit: cover;
    height: 400px;
}

/* Text utilities */
.fs-22 {
    font-size: 22px;
}

.fs-24 {
    font-size: 24px;
}

.smaller {
    font-size: 0.7rem;
}

/* Button hover effects */
.btn-outline-primary,
.btn-outline-success,
.btn-outline-info {
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: translateX(5px);
}

/* Card hover effects */
.card {
    transition: all 0.3s ease;
}

.card:hover:not(.bg-gradient-purple) {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-item img {
        height: 300px;
    }
    
    .display-6 {
        font-size: 1.5rem;
    }
    
    .carousel-caption {
        bottom: 1rem;
        padding: 1rem !important;
    }
    
    .btn-lg {
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
    }
}
</style>