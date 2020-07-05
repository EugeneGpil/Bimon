<template>
    <div>
        <router-link v-for='subject in subjects' v-bind:key='subject.id'
            :to='`/subject/${subject.id}`'
        >
            <div class='text'>
                {{ subject.name }}
            </div>
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