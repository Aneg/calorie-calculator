<script>
export default {
  data () {
    return {
      id_generator: 2,
    }
  },
  methods: {
    generateNextId() {
      this.id_generator += 1;
      return this.id_generator
    },
    generateIdByObject(objects) {
      objects.map((el) => {
        if (!el.id) {
          el.id = this.generateNextId()
        }
        return el
      })
    }
  }
}
</script>
