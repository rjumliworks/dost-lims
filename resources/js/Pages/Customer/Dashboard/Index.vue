<template>
    <PageHeader title="Dashboard" pageTitle="Customer" />
    <b-row class="g-3">
        <div class="col-md-8">
            
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                        <span class="ri-alert-fill  fs-20 me-1"></span>
                        <div class="flex-grow-1 text-truncate">
                           <b>Public Advisory</b>
                        </div>
                        <div class="flex-shrink-0">
                            <!-- <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a> -->
                        </div>
                    </div>

                   <div class="card-body bg-white rounded-bottom">
                        <div class="col-sm-12">
                             <div class="d-flex flex-wrap">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle fs-24 text-success">
                                        <i class="ri-checkbox-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="ms-3 mt-1">
                                    <p class="fw-semibold fs-13 text-success mb-0">Currently Receiving Samples</p>
                                    <h5 class="mb-0 fs-12 text-muted">
                                        Please check operating hours before visiting.
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            
            <!-- <div class="card bg-light-subtle border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:1.5rem;width:1.5rem;" class="mb-2">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-folder-2-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Advisory</span></h5>
                        </div>
                    </div>
                </div>
              
                <div class="card-body bg-white rounded-bottom">
                    <div class="d-flex flex-wrap">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-light rounded-circle fs-24 text-success">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>
                        </div>
                        <div class="ms-3 mt-1">
                            <p class="fw-semibold fs-13 text-truncated mb-0">S&amp;T E-Scholarship </p>
                            <h5 class="mb-0 text-muted fs-12">Web Application System</h5>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="card bg-light-subtle border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-folder-2-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Document Verification</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">TSR verify its authenticity and integrity. </p>
                        </div>
                    </div>
                </div>
              
                <div class="card-body bg-white rounded-bottom">
                    <div class="min-h-screen flex flex-col items-center justify-center text-center bg-gray-50">
                        <div class="alert alert-secondary alert-border-left alert-dismissible fade show material-shadow mt-2 ms-3 me-3" role="alert">
                            <i class="ri-check-double-line me-3 align-middle fs-16"></i>Ensure the authenticity and integrity of your document before submission.
                        </div>
                        <input
                            type="file"
                            accept="application/pdf"
                            @change="onFileChange"
                            class="w-full border border-gray-300 rounded-lg p-2 mb-5 mt-5 "
                        />

                        <button
                            @click="verifyDocument"
                            :disabled="loading || !file"
                            class="bg-primary hover:bg-blue-700 text-white py-2 px-4 rounded-lg w-full disabled:opacity-50"
                        >
                            {{ loading ? 'Verifying...' : 'Verify Document' }}
                        </button>

                        <div v-if="result" class="mt-6 text-center">
                            <div
                            :class="{
                                'text-green-600': result.status === 'valid',
                                'text-red-600': result.status === 'tampered',
                                'text-yellow-600': result.status === 'missing'
                            }"
                            class="text-lg font-medium"
                            >
                            {{ result.message }}
                            </div>
                        </div>

                        <div v-if="error" class="text-red-500 mt-3 text-center text-sm">
                            {{ error }}
                        </div>
                    </div>
                </div>
                   
            </div>
        </div>
    </b-row>
    <!-- <div class="row">
                    <div class="col-lg-8">
                        <div class="card bg-soft bg-light border shadow-none mb-3">
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
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/post-2.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">Announcement</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 6:38 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">2021 DOST-SEI Undergraduate Scholars</h6>
                                        <p>The long wait is over for the applicants to the 20..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/post-1.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">News</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 5:57 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">The DOST-SEI is proud to announce the
                                            qualifiers for the 2021 Junior Level Science Scholarships! </h6>
                                        <p>Congratulations, scholars! May your journey as sci..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/default.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">News</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 5:54 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">STSIMS version 1 released.</h6>
                                        <p>The Science and Technology Scholarship Information..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
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
                    </div>
                </div> -->
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader },
    data() {
    return {
      file: null,
      result: null,
      error: null,
      loading: false,
    }
  },

  methods: {
    onFileChange(e) {
      this.file = e.target.files[0]
      this.result = null
      this.error = null
    },

    async verifyDocument() {
      if (!this.file) return

      this.loading = true
      this.result = null
      this.error = null

      const formData = new FormData()
      formData.append('file', this.file)

      try {
        const response = await axios.post('/verification', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        this.result = response.data
      } catch (err) {
        if (err.response && err.response.data) {
          this.result = err.response.data
        } else {
          this.error = 'Verification failed. Please try again.'
        }
      } finally {
        this.loading = false
      }
    },
  },
}
</script>