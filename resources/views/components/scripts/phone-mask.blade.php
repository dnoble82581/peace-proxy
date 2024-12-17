<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    const phoneInput = document.getElementById('phone')

    phoneInput.addEventListener('input', (event) => {
      let input = phoneInput.value
      let cursorPosition = phoneInput.selectionStart

      // Remove all non-numeric characters
      let numbersOnly = input.replace(/\D/g, '')

      // Limit to maximum length of 10 digits
      if (numbersOnly.length > 10) {
        numbersOnly = numbersOnly.substring(0, 10)
      }

      // Apply formatting
      let formattedInput = ''
      if (numbersOnly.length > 0) {
        formattedInput += '(' + numbersOnly.substring(0, 3)
        if (numbersOnly.length >= 3) {
          formattedInput += ') '
        }
      }
      if (numbersOnly.length > 3) {
        formattedInput += numbersOnly.substring(3, 6)
        if (numbersOnly.length >= 6) {
          formattedInput += '-'
        }
      }
      if (numbersOnly.length > 6) {
        formattedInput += numbersOnly.substring(6, 10)
      }

      // Set the formatted value
      phoneInput.value = formattedInput

      // Adjust cursor position
      const formattedCursorPosition = cursorPosition + (formattedInput.length - input.length)
      phoneInput.setSelectionRange(formattedCursorPosition, formattedCursorPosition)
    })
  })
</script>