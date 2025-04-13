class Formshield {
    constructor(formSelector) {
      this.form = typeof formSelector === 'string' ? document.querySelector(formSelector) : formSelector;
      this.inputs = this.form.querySelectorAll('[data-fs-validate="true"]');
      this.setupListeners();
    }
  
    validators = {
      required: (value) => value.trim() !== '',
      minlength: (value, length) => value.length >= parseInt(length),
      maxlength: (value, length) => value.length <= parseInt(length),
      min: (value, min) => parseFloat(value) >= parseFloat(min),
      max: (value, max) => parseFloat(value) <= parseFloat(max),
      number: (value) => !isNaN(value) && !isNaN(parseFloat(value)),
      integer: (value) => Number.isInteger(parseFloat(value)),
      digits: (value) => /^\d+$/.test(value),
      alphanumeric: (value) => /^[a-zA-Z0-9]+$/.test(value),
      alpha: (value) => /^[a-zA-Z]+$/.test(value),
      url: (value) => /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(value),
      date: (value) => !isNaN(Date.parse(value)),
      time: (value) => /^([01]\d|2[0-3]):([0-5]\d)$/.test(value),
      datetime: (value) => !isNaN(Date.parse(value)),
      email: (value) => /^\S+@\S+\.\S+$/.test(value),
      pattern: (value, regexString) => {
        const regex = new RegExp(regexString);
        return regex.test(value);
      }
    };
  
    async validateInput(input) {
        const value = input.value;
        let isValid = true;
        let message = '';
      
        // Encuentra o crea el contenedor de error
        let container = input.closest('.form-floating');
        let errorContainer = container.querySelector('.error-message');
      
        if (!errorContainer) {
          errorContainer = document.createElement('div');
          errorContainer.classList.add('error-message');
          container.appendChild(errorContainer);
        }
      
        // Validaciones locales
        for (const rule in this.validators) {
          const attr = `data-fs-${rule}`;
          if (input.hasAttribute(attr)) {
            const param = input.getAttribute(attr);
            const valid = this.validators[rule](value, param);
            if (!valid) {
              message = input.getAttribute(`data-fs-error-${rule}`) || 'Campo inválido';
              isValid = false;
              break;
            }
          }
        }
      
        // Validación remota
        if (isValid && input.dataset.remote === "true" && input.dataset.url) {
          try {
            const data = {};
            const fieldName = input.name || 'value';
            data[fieldName] = value;
      
            if (input.dataset.additional) {
              const fields = JSON.parse(input.dataset.additional);
              fields.forEach(fieldName => {
                const field = this.form.querySelector(`[name="${fieldName}"]`);
                if (field) data[fieldName] = field.value;
              });
            }
      
            const response = await fetch(input.dataset.url, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(data)
            });
      
            const result = await response.json();
            if (!result.valid) {
              isValid = false;
              message = input.getAttribute('data-fs-error-remote') || 'Valor no válido';
            }
          } catch (err) {
            isValid = false;
            message = 'Error al validar remotamente';
          }
        }
      
        errorContainer.textContent = isValid ? '' : message;
        input.classList.toggle('is-invalid', !isValid);
        input.classList.toggle('is-valid', isValid);
      
        return isValid;
      }
      
      
  
    setupListeners() {
      this.inputs.forEach(input => {
        input.addEventListener('input', () => this.validateInput(input));
      });
  
      this.form.addEventListener('submit', async (e) => {
        e.preventDefault();
        let formIsValid = true;
  
        for (const input of this.inputs) {
          const valid = await this.validateInput(input);
          if (!valid) formIsValid = false;
        }
  
        if (!formIsValid) {
          const theme = document.documentElement.getAttribute('data-bs-theme') || 'light';
          this.form.setAttribute('data-ajax-validated', 'false');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, corrige los errores en el formulario.',
            customClass: { confirmButton: "btn btn-primary" },
            buttonsStyling: false,
            theme: theme
          });
        }else{
          this.form.setAttribute('data-ajax-validated', 'true');
        }
      });
    }
}

window.Formshield = Formshield;
