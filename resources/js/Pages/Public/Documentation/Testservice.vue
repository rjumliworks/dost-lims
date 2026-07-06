<template>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center mt-lg-5">
                
                 <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h1 class="fs-22 fw-semibold mb-2 lh-base">
                            Test Services Module <span class="text-success">Guide</span>
                        </h1>

                        <p class="lead fs-14 text-muted lh-base mb-0">
                            This guide explains how to create and manage <strong>Test Services</strong> offered by each laboratory, including their corresponding
                            <strong>Methods</strong>, <strong>References</strong>, and <strong>Fees</strong>. Each Test Service can contain one or more Method References,
                            allowing laboratories to maintain standardized testing procedures while supporting multiple analytical methods for the same service.
                        </p>
                    </div>
                </div>

                <div class="row justify-content-center my-4">
            <div class="col-md-9">

                <div class="alert alert-info material-shadow m-4 fs-12 mx-auto" role="alert">
                    <i class="ri-information-line me-1"></i>
                    <strong>Important Notice:</strong><br>
                    Standardizing <strong>Test Services</strong>, <strong>Methods</strong>, and
                    <strong>References</strong> helps ensure consistent laboratory operations across the system.
                    Test Services may be linked to specific <strong>Sample Types</strong> or
                    <strong>Sample Names</strong> to automatically recommend applicable tests during sample
                    registration. However, these recommendations are optional, and users may still select
                    any available Test Service whenever additional or specialized testing is required.
                </div>

                <div class="ratio ratio-16x9 rounded overflow-hidden shadow">
                    <iframe
                        src="https://www.youtube.com/embed/mzzSbJH1a9Y"
                        title="Test Services Module Guide"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>

                <p class="text-center text-muted fs-13 mt-2">
                    Watch the complete walkthrough to learn how to create Test Services, add Method References,
                    define Testing Fees, and manage laboratory testing procedures.
                </p>

            </div>
        </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="profile-timeline p-4">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    
                    
                    <div class="accordion-item border-0" v-for="(step,index) in steps" v-bind:key="index">
                        <div class="accordion-header bg-light rounded-4" id="headingOne">
                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title bg-primary rounded-circle material-shadow fw-bold">
                                            {{ index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-15 mb-0 fw-semibold">{{step.title}}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body ms-2 mt-3 ps-5 pt-0">
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-column">
                                        <ul>
                                            <li v-for="(item, i) in step.items" :key="i">
                                                {{ item }}
                                            </li>
                                        </ul>
                                            <div v-if="step.notice" class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12 mt-auto" role="alert">
                                            <i class="ri-alert-line label-icon"></i>
                                            {{ step.notice }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!-- <div class="col-md-12">
            <section class="section bg-light" id="plans">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container mb-n5">
                    <div class="row justify-content-center mt-n4">
                        <div class="col-lg-12">
                            <div class="text-center mb-5">
                                <h3 class="mb-1 fs-18 text-primary fw-semibold">FUTURE LOGINS</h3>
                                <p class="text-muted mb-4">After successful account activation, you can access the system using the following login options:</p>
                            </div>
                        </div>
                    </div>

                    <div class="row p-5 mt-n5">
                        <div class="col-md-6">
                            <div class="card mb-0">
                                <div class="card-body p-4 m-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-semibold">Option A : Email & Password</h5>
                                            <p class="text-muted mb-0">Use your registered email address and the password you created during activation.</p>
                                        </div>
                                    </div>
                                    <img  :src="`/images/manual/1.jpg`" class="img-fluid mt-3" alt="Responsive image">

                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-0 ribbon-box right">
                                <div class="card-body p-4 m-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-semibold">Option B : Google Login</h5>
                                            <p class="text-muted mb-0">Sign in quickly using your linked Google account for a faster and more convenient login experience.</p>
                                        </div>
                                    </div>
                                    <img  :src="`/images/manual/1-2.jpg`" class="img-fluid mt-3" alt="Responsive image">

                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-n5">
                            <div class="card overflow-hidden shadow-none">
                                <div class="card-body bg-danger-subtle">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-danger bg-opacity-10 text-danger rounded-circle fs-24">
                                                    <i class="ri-alert-fill "></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-16 text-danger fw-semibold mb-0">IMPORTANT NOTICE</h6>
                                            <p class="text-muted mb-0"><b>Mobile OTP (One-Time Password)</b> authentication is temporarily unavailable due to issues with the SMS service provider.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
        </div> -->
    </div>
</template>
<script>
export default {
    data(){
        return {
            steps: [
                {
                    title: 'Create a Test Service',
                    items: [
                        'Open the Test Services module.',
                        'Click the "Add Test Service" button.',
                        'Select the laboratory where the Test Service will be available.',
                        'Enter or select the Test name.'
                    ],
                    notice: 'Each Test Service belongs to a specific laboratory and can have one or more Method References.'
                },
                {
                    title: 'Select or Create a Test Name',
                    items: [
                        'Choose an existing Test name from the dropdown list.',
                        'If the Test name does not exist, click the (+) button beside the Test name field.',
                        'Create and save the new Test name.',
                        'Select the newly created Test name.'
                    ],
                    notice: 'Examples include Moisture, Ash Content, Protein, pH, Total Coliforms, and Lead.'
                },
                {
                    title: 'Search or Create Method References',
                    items: [
                        'Search the existing Method References using the search box to determine if the required Method Reference is already available.',
                        'If the Method Reference exists, select it and proceed.',
                        'If it is not available, click the "Add" button to create a new Method Reference.',
                        'Select an existing Method. If the Method is not listed, click the (+) button to create a new Method by entering its name and optional shortcut.',
                        'Select an existing Reference. If the Reference is not listed, click the (+) button to create a new Reference.',
                        'Enter the applicable testing fee.',
                        'Click "Submit" to save the Method Reference.',
                        'Select the newly created Method Reference from the list to associate it with the Test Service.'
                    ],
                    notice: 'Always search for an existing Method Reference before creating a new one to avoid duplicate Methods and References. A single Test Service may have multiple Method References, each with its own testing fee.'
                },
                {
                    title: 'Create New Methods or References (Optional)',
                    items: [
                        'If the required Method does not exist, click the (+) button beside the Method field.',
                        'Enter the Method name and optional short description.',
                        'Likewise, create a new Reference using the (+) button beside the Reference field.',
                        'After saving, select the newly created Method and Reference.'
                    ],
                    notice: 'This allows laboratories to continuously expand their list of approved testing methods and references.'
                },
                {
                    title: 'Save the Test Service',
                    items: [
                        'Review the selected Laboratory and Test Service.',
                        'Verify that all Method References and Fees are correct.',
                        'Click "Submit" to save the Test Service.',
                        'The Test Service can now be linked to Sample Types or Sample Names for automatic recommendations during sample registration.'
                    ],
                    notice: 'You may add multiple Method References to a single Test Service whenever applicable.'
                }
            ]
        }
    }
}
</script>