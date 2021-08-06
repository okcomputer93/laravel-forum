<template>
    <div>

        <form class="mt-4"
              v-if="signedIn"
              @submit="addReply"
        >
            <div class="form-group">
                <textarea placeholder="Have something to say?"
                          name="body"
                          id="body"
                          rows="5"
                          class="form-control"
                          required
                          v-model="body"
                >
                </textarea>
            </div>
            <button type="submit"
                    class="btn btn-primary"
            >
                Post
            </button>
        </form>

        <p class="text-center mt-4"
           v-else
        >
            Please <a href="/login">sign in</a> to participate in this
            discussion.
        </p>
    </div>
</template>

<script>
export default {
    name: "NewReply.vue",
    props: ['action'],
    data() {
        return {
            body: ''
        }
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },
    methods: {
        async addReply(event) {
            event.preventDefault();
            const response = await axios.post(this.action, {
                body: this.body
            });
            this.body = '';
            flash('Your reply has been posted.');
            this.$emit('created', response.data);
        }
    }
}
</script>

<style scoped>

</style>
