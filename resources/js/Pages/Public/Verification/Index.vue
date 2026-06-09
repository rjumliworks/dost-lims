<template>
    <Head title="Verification"/>
   
</template>
<script>
export default {
    layout: null,
    props: ['tsr','samples','analyses'],
    data() {
        return {
            togglePassword: false
        }
    },
    methods: {
        modifiedSentence(data) {
            if (data.length >= 8) {
                const firstFour = data.slice(0, 4);
                const lastFour = data.slice(-4);
                const modified = `${firstFour}******${lastFour}`;
                return modified;
            } else {
                return data;
            }
        },
    }
}
</script>
<style scoped>
.auth-page-wrapper {
    background-color: hsl(201, 80%, 82%);
}
</style>
