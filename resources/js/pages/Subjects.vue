<template>
    <div>
        <router-link v-for='subject in subjects' v-bind:key='subject.id'
            :to='`/subject/${subject.id}`'
        >
            {{ subject.name }}
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'subjects',
    data() {
        return {
            subjects: []
        }
    },
    mounted() {
        axios.get('/api/subjects').then(response => {
            this.subjects = response.data;
        });
    }
}
</script>