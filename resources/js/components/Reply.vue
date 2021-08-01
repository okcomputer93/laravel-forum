
<script>
export default {
    name: "Reply.vue",
    props: ['attributes'],
    data() {
        return {
            editing: false,
            body: this.attributes.body
        }
    },
    methods: {
        async update() {
            await axios.patch(`/replies/${this.attributes.id}`, {
                body: this.body
            });

            this.editing = false;

            flash('Updated!');
        }
    }
}
</script>

<style>

</style>
