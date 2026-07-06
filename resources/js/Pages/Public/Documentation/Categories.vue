<template>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center mt-lg-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h1 class="fs-22 fw-semibold mb-2 lh-base">
                            Categories Module <span class="text-success">Guide</span>
                        </h1>

                        <p class="lead fs-14 text-muted lh-base mb-0">
                            This guide explains how to manage laboratory sample classifications using a three-level hierarchy:
                            <strong>Category</strong>, <strong>Type</strong>, and <strong>Name</strong>. This structure helps laboratories organize and standardize sample classifications. For example, the category <strong>Animal-Based Food Products</strong> contains the type <strong>Meat</strong>, which includes sample names such as <strong>Raw Meat, Fresh Meat, Chilled Meat, Frozen Meat, Cured Meat, and other meat products</strong>.
                        </p>
                    </div>
                </div>
               
              

                <div class="row justify-content-center my-4">
                    <div class="col-md-9">
                          <div class="alert alert-danger material-shadow m-4 fs-12 mx-auto" role="alert">
                    <i class="ri-information-line me-1"></i>
                    <strong>Important Notice:</strong><br>
                    Maintaining standardized <strong>Categories</strong>, <strong>Types</strong>, and <strong>Names</strong> ensures consistent sample classification throughout the Laboratory Information Management System (LIMS). This standardized hierarchy is used when generating reports, including the <strong>Top 10 Samples</strong> by Category, Type, or Name, providing accurate and uniform statistical results across all laboratories. In addition, <strong>Test Services</strong> can be linked to specific sample Types or Names, allowing the system to automatically suggest the appropriate test services whenever users register samples under the corresponding Category, Type, or Name.
                </div>
                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow">
                            <iframe
                                src="https://www.youtube.com/embed/NJYkh2fSU90"
                                title="Categories Module Guide"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <p class="text-center text-muted fs-13 mt-2">
                            Watch the complete walkthrough before following the step-by-step instructions below.
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

        <div class="col-md-12">
            <section class="section bg-light" id="plans">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container mb-n5">
          

                    <div class="row justify-content-center mt-n4 mb-4">
                        <div class="col-md-9 text-center">
                            <h3 class="mb-1 fs-18 text-primary fw-semibold">WHERE SAMPLE CLASSIFICATIONS ARE USED</h3>
                            <p class="text-muted mb-4"> Categories, Sample Types, and Sample Names are utilized throughout the Laboratory Information Management System (LIMS) to ensure standardized laboratory operations and reporting.</p>
                        </div>
                    </div>

                    <div class="row p-5 mt-n5">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                                                <i class="ri-bar-chart-box-line"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <h5 class="mb-1 fw-semibold">
                                                Reports and Statistics
                                            </h5>
                                            <p class="text-muted mb-0">
                                                Used for analytical reports and statistical summaries.
                                            </p>
                                        </div>
                                    </div>

                                    <ul class="text-muted mb-0">
                                        <li>Generate accurate Top 10 reports by Sample Name.</li>
                                        <li>Ensure consistent sample classifications across all laboratories.</li>
                                        <li>Eliminate duplicate or inconsistent sample names caused by manual entry (e.g., <strong>Water</strong>, <strong>water</strong>, <strong>WATER</strong>, or <strong>waters</strong>).</li>
                                        <li>Improve the accuracy of laboratory statistics, dashboards, and management reports.</li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                        <!-- Test Services -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3">
                                            <div class="avatar-title bg-success-subtle text-success rounded-circle fs-20">
                                                <i class="ri-links-line"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <h5 class="mb-1 fw-semibold">
                                                Test Service Recommendations
                                            </h5>
                                            <p class="text-muted mb-0">
                                                Connect sample classifications with laboratory services.
                                            </p>
                                        </div>
                                    </div>

                                    <ul class="text-muted mb-0">
                                        <li>Link Test Services to Sample Types</li>
                                        <li>Link Test Services to Sample Names</li>
                                        <li>Automatically recommend applicable Test Services during sample registration</li>
                                        <li>Reduce manual selection and improve consistency</li>
                                    </ul>

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
                                            <p class="text-muted mb-0">
                                                Linking <strong>Test Services</strong> to specific <strong>Sample Types</strong> or
                                                <strong>Sample Names</strong> is intended to provide recommendations during sample
                                                registration. However, users are <strong>not restricted</strong> to these suggested
                                                Test Services. Any available Test Service may still be selected whenever necessary,
                                                providing flexibility for special cases or newly introduced testing requirements.
                                            </p>
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
</template>
<script>
export default {
    data(){
        return {
            steps: [
                {
                    title: 'Select the Laboratory',
                    items: [
                        'Click the "Add Sample Name" button.',
                        'Select the laboratory where the sample classification will be used.',
                        'The selected laboratory determines the available Categories and Types.'
                    ],
                    images: [
                        'category-1.jpg'
                    ],
                    notice: 'Always ensure the correct laboratory is selected before creating or updating sample classifications.'
                },
                {
                    title: 'Select or Create a Category',
                    items: [
                        'Choose an existing Category from the dropdown list.',
                        'If the Category does not exist, click the (+) button beside the Category field.',
                        'Create and save the new Category.',
                        'Select the newly created Category.'
                    ],
                    images: [
                        'category-2.jpg'
                    ],
                    notice: 'Categories represent the highest level of sample classification (e.g., Animal-Based Food Products, Water, Soil, etc.).'
                },
                {
                    title: 'Select or Create a Sample Type',
                    items: [
                        'Choose an existing Sample Type under the selected Category.',
                        'If the Sample Type is unavailable, click the (+) button beside the Sample Type field.',
                        'Create and save the new Sample Type.',
                        'Select the newly created Sample Type.'
                    ],
                    images: [
                        'category-3.jpg'
                    ],
                    notice: 'Sample Types are grouped under a Category (e.g., Meat, Fish, Dairy Products).'
                },
                {
                    title: 'Enter the Sample Name',
                    items: [
                        'Enter the specific Sample Name.',
                        'Use a descriptive and standardized name.',
                        'Examples include Raw Meat, Fresh Meat, Frozen Meat, Chilled Meat, and Smoked Meat.'
                    ],
                    images: [
                        'category-4.jpg'
                    ],
                    notice: 'Consistent sample names improve search results, reporting, and automatic Test Service recommendations.'
                },
                {
                    title: 'Save the Sample Name',
                    items: [
                        'Review the selected Laboratory, Category, Type, and Sample Name.',
                        'Click the "Submit" button to save the new Sample Name.',
                        'The new Sample Name will now be available for sample registration.'
                    ],
                    images: [
                        'category-5.jpg'
                    ]
                }
            ]
        }
    }
}
</script>