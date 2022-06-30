<script>
import { DateTime } from 'luxon'

export default {
  name: 'FormatDateTime',
  props: {
    value: {
      type: String,
      required: true,
    },
  },
  render() {
    return this._v(this.formatted)
  },
  computed: {
    formatted() {
      return DateTime.fromISO(this.value).toLocaleString({
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
      })
    },
  },
}
</script>
