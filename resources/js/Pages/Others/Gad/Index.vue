<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-soft bg-light border shadow-none mb-3" >
                <div class="p-1">
                    <div class="d-flex mt-1">
                        <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                            <div class="avatar-title rounded bg-transparent"><i
                                    class="bx bx-news h4 mt-1"></i></div>
                        </div>
                        <div class="overflow-hidden mr-auto align-self-center">
                            <h5 class="fw-semibold fs-12 mt-1">Announcements</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body border shadow-none">
                        <BCarousel class="carousel slide" ride="carousel" :interval="2000" controls indicators>
                            <BCarouselSlide active :img-src="Img1">
                            <h5 class="text-white">Sunrise above a beach</h5>
                            <p class="text-white-50">
                                You've probably heard that opposites attract. The same
                                is true for fonts. Don't be afraid to combine font
                                styles that are different but complementary.
                            </p>
                            </BCarouselSlide>
                            <BCarouselSlide :img-src="Img2">
                            <h5 class="text-white">Working from home little spot</h5>
                            <p class="text-white-50">
                                Consistency piques people’s interest is that it has
                                become more and more popular over the years, which is
                                excellent.
                            </p>
                            </BCarouselSlide>
                            <BCarouselSlide :img-src="Img3">
                            <h5 class="text-white">
                                Dramatic clouds at the Golden Gate Bridge
                            </h5>
                            <p class="text-white-50">
                                Increase or decrease the letter spacing depending on the
                                situation and try, try again until it looks right, and
                                each letter.
                            </p>
                            </BCarouselSlide>
                        </BCarousel>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-4">
            <div class="card bg-soft bg-light border shadow-none mb-3">
                <div class="p-1">
                    <div class="d-flex mt-1">
                        <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                            <div class="avatar-title rounded bg-transparent"><i
                                    class="bx bx-info-circle h4 mt-1"></i></div>
                        </div>
                        <div class="overflow-hidden mr-auto align-self-center">
                            <h5 class="fw-semibold fs-12 mt-1">Quick Links</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border"><a href="https://www.science-scholarships.ph" target="_blank">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light rounded-circle fs-20 text-primary">
                                    <i class="bx bxs-window-alt"></i>
                                </div>
                            </div>
                            <div class="ms-3 mt-1">
                                <p class="fw-semibold fs-13 text-truncated mb-0">S&amp;T E-Scholarship </p>
                                <h5 class="mb-0 text-muted fs-12">Web Application System</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="card border mt-n3">
                <a href="https://www.sei.dost.gov.ph/images/stsd/ugradFAQ.pdf" target="_blank">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="avatar-sm">
                                <div
                                    class="avatar-title bg-light rounded-circle font-size-20 text-warning">
                                    <i class="bx bxs-user-voice"></i></div>
                            </div>
                            <div class="ms-3 mt-1">
                                <p class="fw-semibold fs-13 text-truncated text-warning mb-0">Frequently Asked
                                    Questions </p>
                                <h5 class="mb-0 text-muted fs-12">DOST - Science Education
                                    Institute</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="card border mt-n3">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <div class="avatar-sm">
                            <div
                                class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                <img src="images/sei.png" alt="" class="ms-1" style="width: 25px;">
                            </div>
                        </div>
                        <div class="ms-3 mt-1"><a href="https://www.sei.dost.gov.ph/"
                                target="_blank">
                                <p class="fw-semibold fs-13 text-truncated mb-0">Science Education Institute
                                </p>
                            </a> <a href="https://www.dost.gov.ph/" target="_blank">
                                <h5 class="mb-0 text-muted fs-12">Department of Science and
                                    Technology
                                </h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group bg-light rounded mb-3"><input type="email"
                    placeholder="Enter Email address" aria-label="Recipient's username"
                    aria-describedby="button-addon2" class="form-control bg-transparent border-0">
                <div class="input-group-append"><button type="button" id="button-addon2"
                        class="btn btn-primary rounded"><i class="bx bx-envelope"></i></button>
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
import Img1 from "@assets/images/small/1.png";
import Img2 from "@assets/images/small/2.jpg";
import Img3 from "@assets/images/small/3.jpg";
export default {
    data() {
        return {
            Img1, Img2, Img3, 
        };
  },
}
</script>
