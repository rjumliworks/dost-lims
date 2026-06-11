<template>
    <div id="layout-wrapper" class="auth-page-wrapper pt-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content">
            <BContainer>

                <BRow class="justify-content-center">
                    <BCol lg="12">
                        <div class="card bg-light-subtle shadow-none border">
                            <div class="card-header bg-primary">
                                <div class="d-flex mb-n2">
                                    <div class="flex-shrink-0 me-3">
                                        <div style="height:2.5rem;width:2.5rem;">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                        </div>
                                    </div>
                                    <!-- <div class="flex-grow-1">
                                        <h5 class="mb-0 mt-2 fs-14"><span class="text-white fw-semibold text-uppercase fs-13">Department Of Science and Technology</span></h5>
                                        <p class="text-white fs-11">Unified Information Management System</p>
                                    </div> -->
                                     <div class="flex-grow-1">
                                        <h5 class="mb-0 mt-2 fs-14 fw-semibold text-uppercase text-white" style="font-size: 10.7px">DEPARTMENT OF SCIENCE AND TECHNOLOGY</h5>
                                        <p class="text-white fs-11"><span class="fw-semibold">One<span class="text-info">DOST</span>4U</span> : <span class="text-muted">Laboratory Information Management System</span></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="mb-0 mt-2 fs-24 me-3 fw-semibold text-uppercase text-white">USER MANUAL</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="car-body bg-white shadow-none" style="height: calc(100vh - 250px); overflow-y: auto; overflow-x:hidden;">
                                

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center mt-lg-5">
                                                <h1 class="fs-22 fw-semibold mb-0 lh-base">Account Activation and <span class="text-success">First-Time Login Guide</span></h1>
                                                <p class="lead fs-14 text-muted lh-base">This guide will help you complete account activation and successfully access the system for the first time.</p>
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
                                                                    <div class="col-md-5 d-flex flex-column">
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
                                                                    <div class="col-md-7 text-center" style="margin-top: 0px;">
                                                                        <img v-for="(item, i) in step.images" :key="i" :src="`/images/manual/${item}`" class="img-fluid" alt="Responsive image"  style="height:250px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end row -->

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
                                                        <!--end col-->
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
                                        </div>
                                    </div>






                            </div>
                            <div class="card-footer bg-light-subtle mb-n4">
                                 <div class="text-center p-1">
                                    <p class="mb-0 fs-11 text-muted">Thank you for helping us maintain a secure and reliable system.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </BCol>
                </BRow>
            </BContainer>
        </div>
    </div>
</template>
<script>
export default {
    layout: null,
    data(){
        return {
            steps: [
                {
                title: 'Sign in with Google (Gmail)',
                    items: [
                        'Go to limsv3.dost9.ph',
                        'Open the LIMS login page',
                        'Click the Google (Gmail) icon.',
                        'Sign in using your official Gmail account.'
                    ],
                    images: [
                        '1.jpg',
                        '1-2.jpg'
                    ],
                    notice: 'Use the Gmail account linked to your account'
                },
                {
                title: 'Enter Activation Code',
                    items: [
                        'Check your Gmail inbox.',
                        'If it is not visible, check the Spam folder.',
                        'Open the activation email.',
                        'Copy the activation code.',
                        'Paste the code into the web app.',
                        'Click "Go set password" button'
                    ],
                    images: [
                        '2.jpg',
                        '2-1.jpg'
                    ]
                },
                {
                title: 'Create Password',
                    items: [
                        'Create a secure password.',
                        'Confirm your password.',
                        'Both passwords must match.', 
                        'This step will be marked as completed (green).',
                        'Click "Next" button'
                    ],
                    images: [
                        '3.jpg'
                    ],
                    notice: 'Passwords must be at least 8 characters and include uppercase and lowercase letters, numbers, and special characters.'
                },
                {
                title: 'Upload Profile Photo',
                    items: [
                        'Upload your official profile picture.',
                        'File size must be 2MB or below.',
                        'The Next button will appear once the image is successfully uploaded.',
                        'Click "Next" button'
                    ],
                    images: [
                        '4.jpg'
                    ],
                    notice:
                        'Use the photo where you are wearing the BLUE POLO UNIFORM. This image will be used for identification purposes within the system.'
                    },
                {
                title: 'Review and Activate Account',
                    items: [
                        'Review your information.',
                        'All items must be completed before this step will be marked as completed (green check).',
                        'Click the "Agreed and Activate" button.'
                    ],
                    images: [
                        '5.jpg'
                    ],
                },
                {
                title: 'Access the System',
                    items: [
                        'You will be redirected to the Dashboard/Home Page.',
                        'Your account is now active and ready to use.'
                    ],
                    images: [
                        '6.jpg'
                        ],
                    }
            ]
        }
    }
}
</script>