<template>
    <div class="">
        <!-- Welcome Banner - Minimalist with Animated Gradient -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 animated-gradient overflow-hidden">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h2 class="fw-semibold text-white mb-2">Lipunang Patas sa Bagong Pilipinas</h2>
                                <p class="text-white text-opacity-85 fs-6 mb-3">Gender and development resources, policies, and learning materials</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-white bg-opacity-15 text-white px-3 py-1 rounded-pill"><i class="ri-file-pdf-line me-1"></i> 1,247 Resources</span>
                                    <span class="badge bg-white bg-opacity-15 text-white px-3 py-1 rounded-pill"><i class="ri-download-line me-1"></i> 45.2K Downloads</span>
                                    <span class="badge bg-white bg-opacity-15 text-white px-3 py-1 rounded-pill"><i class="ri-user-line me-1"></i> 3,891 Active</span>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end d-none d-lg-block">
                                <i class="ri-bar-chart-2-fill text-white opacity-15" style="font-size: 6rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="row g-3 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm hover-card bg-soft-primary">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-lg bg-primary rounded-3 me-3">
                            <i class="ri-file-text-line fs-24 text-white avatar-title"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Laws & Policies</h6>
                            <h4 class="mb-0 fw-bold">156</h4>
                            <small class="text-success"><i class="ri-arrow-up-line"></i> +12 new</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm hover-card bg-soft-success">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-lg bg-success rounded-3 me-3">
                            <i class="ri-video-line fs-24 text-white avatar-title"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">IEC Materials</h6>
                            <h4 class="mb-0 fw-bold">423</h4>
                            <small class="text-success"><i class="ri-arrow-up-line"></i> +8 new</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm hover-card bg-soft-warning">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-lg bg-warning rounded-3 me-3">
                            <i class="ri-tools-line fs-24 text-white avatar-title"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Training Modules</h6>
                            <h4 class="mb-0 fw-bold">89</h4>
                            <small class="text-warning"><i class="ri-arrow-right-line"></i> In progress</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm hover-card bg-soft-info">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-lg bg-info rounded-3 me-3">
                            <i class="ri-group-line fs-24 text-white avatar-title"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Webinars</h6>
                            <h4 class="mb-0 fw-bold">24</h4>
                            <small class="text-info"><i class="ri-calendar-line"></i> This month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Featured Carousel -->
                <div class="card border-0 shadow-lg overflow-hidden rounded-4 mb-4">
                    <BCarousel 
                        class="carousel slide carousel-fade" 
                        ride="carousel" 
                        :interval="5000" 
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
                            <!-- Optional: Add carousel captions here if needed -->
                        </BCarouselSlide>
                        
                        <BCarouselSlide 
                            :img-src="Img2"
                            img-height="400"
                            img-width="1200"
                        >
                            <!-- Optional: Add carousel captions here if needed -->
                        </BCarouselSlide>
                        
                        <BCarouselSlide 
                            :img-src="Img3"
                            img-height="400"
                            img-width="1200"
                        >
                            <!-- Optional: Add carousel captions here if needed -->
                        </BCarouselSlide>
                    </BCarousel>
                    
                    <!-- Carousel Stats -->
                    <div class="position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-transparent d-none d-lg-block" style="z-index: 10;">
                        <div class="d-flex gap-5 text-white">
                            <div class="d-flex align-items-center">
                                <i class="ri-eye-line fs-22 me-2"></i>
                                <div>
                                    <small class="opacity-75">Views</small>
                                    <h6 class="mb-0 text-white">12.5K</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ri-share-line fs-22 me-2"></i>
                                <div>
                                    <small class="opacity-75">Shares</small>
                                    <h6 class="mb-0 text-white">2.8K</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ri-heart-line fs-22 me-2"></i>
                                <div>
                                    <small class="opacity-75">Reactions</small>
                                    <h6 class="mb-0 text-white">486</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm stats-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md bg-primary bg-gradient rounded-circle">
                                            <i class="ri-file-copy-line fs-24 text-white avatar-title"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="text-muted text-uppercase small fw-semibold">Resources</span>
                                        <h3 class="mb-0 fw-bold">1,247</h3>
                                        <span class="text-success small"><i class="ri-arrow-up-line"></i> +12%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm stats-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md bg-success bg-gradient rounded-circle">
                                            <i class="ri-download-2-line fs-24 text-white avatar-title"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="text-muted text-uppercase small fw-semibold">Downloads</span>
                                        <h3 class="mb-0 fw-bold">45.2K</h3>
                                        <span class="text-success small"><i class="ri-arrow-up-line"></i> +8%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm stats-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md bg-info bg-gradient rounded-circle">
                                            <i class="ri-user-line fs-24 text-white avatar-title"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="text-muted text-uppercase small fw-semibold">Active Users</span>
                                        <h3 class="mb-0 fw-bold">3,891</h3>
                                        <span class="text-success small"><i class="ri-arrow-up-line"></i> +5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fw-semibold mb-0"><i class="ri-folder-line text-purple me-2"></i>Browse by Category</h4>
                            <a href="#" class="text-purple small">View all <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="category-card text-center p-3 rounded-3 border">
                                    <div class="avatar-md bg-soft-purple rounded-circle mx-auto mb-2">
                                        <i class="ri-gavel-line fs-24 text-purple avatar-title"></i>
                                    </div>
                                    <h6 class="mb-1">Laws</h6>
                                    <small class="text-muted">156 items</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="category-card text-center p-3 rounded-3 border">
                                    <div class="avatar-md bg-soft-purple rounded-circle mx-auto mb-2">
                                        <i class="ri-file-text-line fs-24 text-purple avatar-title"></i>
                                    </div>
                                    <h6 class="mb-1">Policies</h6>
                                    <small class="text-muted">89 items</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="category-card text-center p-3 rounded-3 border">
                                    <div class="avatar-md bg-soft-purple rounded-circle mx-auto mb-2">
                                        <i class="ri-video-line fs-24 text-purple avatar-title"></i>
                                    </div>
                                    <h6 class="mb-1">IEC Materials</h6>
                                    <small class="text-muted">423 items</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="category-card text-center p-3 rounded-3 border">
                                    <div class="avatar-md bg-soft-purple rounded-circle mx-auto mb-2">
                                        <i class="ri-graduation-cap-line fs-24 text-purple avatar-title"></i>
                                    </div>
                                    <h6 class="mb-1">Trainings</h6>
                                    <small class="text-muted">67 items</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Resources -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fw-semibold mb-0"><i class="ri-time-line text-purple me-2"></i>Recently Added</h4>
                            <a href="#" class="text-purple small">View all <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Date Added</th>
                                        <th>Downloads</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-file-pdf-line text-danger me-2 fs-18"></i>
                                                <span class="fw-medium">RA 11313 - Safe Spaces Act</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-purple text-purple">Republic Act</span></td>
                                        <td>March 15, 2025</td>
                                        <td>1.2K</td>
                                        <td><button class="btn btn-sm btn-soft-primary rounded-pill">Download</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-file-pdf-line text-danger me-2 fs-18"></i>
                                                <span class="fw-medium">JMC 2025-01: GAD Budget Guidelines</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-purple text-purple">Memorandum</span></td>
                                        <td>March 12, 2025</td>
                                        <td>856</td>
                                        <td><button class="btn btn-sm btn-soft-primary rounded-pill">Download</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-file-video-line text-info me-2 fs-18"></i>
                                                <span class="fw-medium">GAD Orientation Module (Video)</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-info text-info">IEC Material</span></td>
                                        <td>March 10, 2025</td>
                                        <td>2.3K</td>
                                        <td><button class="btn btn-sm btn-soft-primary rounded-pill">Watch</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-file-word-line text-primary me-2 fs-18"></i>
                                                <span class="fw-medium">VAW Desk Handbook 2025</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-success text-success">Handbook</span></td>
                                        <td>March 08, 2025</td>
                                        <td>567</td>
                                        <td><button class="btn btn-sm btn-soft-primary rounded-pill">Download</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Search Bar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="ri-search-line text-muted"></i></span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="Search resources...">
                            <button class="btn btn-purple rounded-pill px-4" type="button">Go</button>
                        </div>
                    </div>
                </div>

                <!-- News & Updates - Updated with Facebook Posts -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="fw-semibold mb-0"><i class="ri-news-line text-purple me-2"></i>GAD News & Updates</h5>
                            <span class="badge bg-purple text-white rounded-pill">3 new</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-4">
                            <!-- Ellyssa Post 1 -->
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-soft-info rounded-circle">
                                        <i class="ri-government-line text-info avatar-title"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">DOST IX "Shuttle Her Power" Badminton Tournament</h6>
                                    <p class="text-muted small mb-1">
                                        The top pairs from Brackets C, D, and E have been determined! 
                                        The tournament continues on March 20, 2026, for the quarterfinals, semifinals, and finals.
                                    </p>
                                    <small class="text-purple">
                                        <a href="https://www.facebook.com/DOSTRegion9/posts/pfbid08ZtMBy2PjTo6adoYfh1hbFwT2dspAPNPVkwFfdGC3QkA6jk1UmzaE6dHm6uebZrtl" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="text-purple text-decoration-none">
                                            <i class="ri-facebook-line me-1"></i>View post on Facebook
                                            <i class="ri-external-link-line ms-1" style="font-size: 0.8rem;"></i>
                                        </a>
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex">
                <div class="flex-shrink-0">
                    <div class="avatar-sm bg-soft-info rounded-circle">
                        <i class="ri-government-line text-info avatar-title"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">DOST IX - International Women's Day Greeting</h6>
                    <p class="text-muted small mb-1">
                        "Celebrating strength, resilience, and empowerment - Happy International Women's Day from the PSTO-ZSP!" 
                        <span class="text-dark">#WEcanbeEquALL</span>
                    </p>
                    <small class="text-purple">
                        <a :href="dostPost1Url" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="text-purple text-decoration-none">
                            <i class="ri-facebook-line me-1"></i>View post on Facebook
                            <i class="ri-external-link-line ms-1" style="font-size: 0.8rem;"></i>
                        </a>
                    </small>
                </div>
            </div>

            <!-- DOST Post 2: Women's Month Kick-off Activities -->
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <div class="avatar-sm bg-soft-success rounded-circle">
                        <i class="ri-government-line text-success avatar-title"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">DOST IX Launches Women's Month 2026</h6>
                    <p class="text-muted small mb-1">
                        Kicked off with "Marcha De Las Mujeres," "Babaylan Beats: Friday Zumba," and the "Shuttle Her Power" badminton tournament. 
                        Celebrating the theme "Live like Babaylans, Filipinas."
                    </p>
                    <small class="text-purple">
                        <a :href="dostPost2Url" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="text-purple text-decoration-none">
                            <i class="ri-facebook-line me-1"></i>View post on Facebook
                            <i class="ri-external-link-line ms-1" style="font-size: 0.8rem;"></i>
                        </a>
                    </small>
                </div>
            </div>

                           
                        </div>
                        <div class="mt-4 text-center">
                            <a href="https://www.facebook.com/ellyssa" 
                               target="_blank"
                               class="btn btn-soft-primary rounded-pill px-4">
                                <i class="ri-facebook-line me-2"></i>Follow for Updates
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4">
                        <h5 class="fw-semibold mb-0"><i class="ri-calendar-event-line text-purple me-2"></i>Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-3">
                            <div class="d-flex align-items-center">
                                <div class="event-date bg-soft-purple text-center rounded-3 p-2 me-3" style="min-width: 60px;">
                                    <span class="fw-bold d-block text-purple">25</span>
                                    <small class="text-muted">MAR</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">GAD Focal Point System Training</h6>
                                    <p class="text-muted small mb-0"><i class="ri-time-line me-1"></i> 9:00 AM - 5:00 PM</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="event-date bg-soft-purple text-center rounded-3 p-2 me-3" style="min-width: 60px;">
                                    <span class="fw-bold d-block text-purple">28</span>
                                    <small class="text-muted">MAR</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">Webinar: Gender-Responsive Planning</h6>
                                    <p class="text-muted small mb-0"><i class="ri-time-line me-1"></i> 10:00 AM - 12:00 NN</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="event-date bg-soft-purple text-center rounded-3 p-2 me-3" style="min-width: 60px;">
                                    <span class="fw-bold d-block text-purple">02</span>
                                    <small class="text-muted">APR</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">VAW Desk Officers Summit</h6>
                                    <p class="text-muted small mb-0"><i class="ri-time-line me-1"></i> 8:30 AM - 5:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Resource -->
                <div class="card bg-gradient-purple border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="avatar-lg mx-auto bg-white bg-opacity-15 rounded-circle mb-3">
                                <i class="ri-star-line fs-32 text-white avatar-title"></i>
                            </div>
                            <span class="badge bg-warning text-dark mb-2">FEATURED RESOURCE</span>
                            <h4 class="text-white fw-semibold">Safe Spaces Act</h4>
                            <p class="text-white-50 small">Comprehensive guide with IRR and downloadable forms</p>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between text-white">
                                <span><i class="ri-download-line me-1"></i> Downloads</span>
                                <span class="fw-bold">2.5K this week</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 75%"></div>
                            </div>
                        </div>
                        <button class="btn btn-light w-100 rounded-pill py-2">
                            <i class="ri-arrow-right-circle-line me-2"></i> Access Resource
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="text-muted mb-2 mb-md-0">
                                    <i class="ri-heart-fill text-danger me-1"></i> 
                                    Philippine Commission on Women · GAD Knowledge & IEC
                                </p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-muted">
                                    <i class="ri-time-line me-1"></i> Updated: March 18, 2025
                                    <span class="mx-2">|</span>
                                    <i class="ri-file-copy-line me-1"></i> 1,247 resources
                                </small>
                            </div>
                        </div>
                    </div>
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
/* Animated Gradient Background */
.animated-gradient {
    background: linear-gradient(-45deg, #4158D0, #C850C0, #FFCC70, #6b21a5);
    background-size: 300% 300%;
    animation: gradientMove 8s ease infinite;
    border-radius: 1rem;
}

@keyframes gradientMove {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Other styles remain the same */
.hover-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.stats-card {
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    background-color: #f8f4ff;
    border-color: #6b21a5 !important;
    transform: scale(1.05);
}

.avatar-lg {
    height: 56px;
    width: 56px;
}

.avatar-md {
    height: 48px;
    width: 48px;
}

.avatar-sm {
    height: 40px;
    width: 40px;
}

.avatar-title {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fs-18 {
    font-size: 18px;
}

.fs-22 {
    font-size: 22px;
}

.fs-24 {
    font-size: 24px;
}

.fs-32 {
    font-size: 32px;
}

.event-date {
    transition: all 0.3s ease;
}

.event-date:hover {
    background-color: #6b21a5 !important;
}

.event-date:hover span,
.event-date:hover small {
    color: white !important;
}

.btn-purple {
    background-color: #6b21a5;
    color: white;
    border: none;
}

.btn-purple:hover {
    background-color: #7e22ce;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(107, 33, 165, 0.3);
}

.bg-soft-purple {
    background-color: #f3e8ff;
}

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

.text-purple {
    color: #6b21a5;
}

.bg-gradient-purple {
    background: linear-gradient(135deg, #6b21a5 0%, #a21caf 100%);
}

.bg-gradient-transparent {
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
}

/* Carousel customization */
.carousel-item img {
    object-fit: cover;
    height: 400px;
}

/* Text opacity utilities */
.text-opacity-85 {
    opacity: 0.85;
}

.text-opacity-15 {
    opacity: 0.15;
}

.bg-opacity-15 {
    --bs-bg-opacity: 0.15;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-item img {
        height: 300px;
    }
    
    .display-5 {
        font-size: 1.8rem;
    }
    
    .btn-lg {
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
    }
}
</style>