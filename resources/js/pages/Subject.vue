<template>
    <div class='wrapper'>
        <router-link v-for='lesson in lessons' v-bind:key='lesson.id'
            :to='`/lesson/${lesson.id}`'
        >
            <div class='text'>
                {{ lesson.name }}
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'subject',
    data() {
        return {
            lessons: []
        }
    },
    mounted() {
        axios.get(`/api/subject?id=${this.$route.params.id}`).then(response => {
            this.lessons = response.data.lessons
        });
    }
}
</script>

<style scoped>
.wrapper {
    display: flex;
    flex-direction: column;
}
</style>