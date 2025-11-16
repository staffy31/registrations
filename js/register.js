(function() {
  'use strict'
  const form = document.getElementById('regForm');
  form.addEventListener('submit', async function(event) {
    event.preventDefault();
    event.stopPropagation();

    // manual validation
    let valid = true;
    if (!form.id.value.trim()) { form.id.classList.add('is-invalid'); valid = false; } else { form.id.classList.remove('is-invalid'); }
    if (!form.family_name.value.trim()) { form.family_name.classList.add('is-invalid'); valid = false; } else { form.family_name.classList.remove('is-invalid'); }
    if (!form.given_name.value.trim()) { form.given_name.classList.add('is-invalid'); valid = false; } else { form.given_name.classList.remove('is-invalid'); }
    if (!form.gender.value) { form.gender.classList.add('is-invalid'); valid = false; } else { form.gender.classList.remove('is-invalid'); }
    if (form.phone.value && !/^[0-9+()\\-\\s]{7,20}$/.test(form.phone.value)) { form.phone.classList.add('is-invalid'); valid = false; } else { form.phone.classList.remove('is-invalid'); }

    if (!valid) {
      Swal.fire({icon:'error', title:'Validation', text:'Please fix the highlighted fields.'});
      return;
    }

    const payload = {
      id: form.id.value.trim(),
      family_name: form.family_name.value.trim(),
      given_name: form.given_name.value.trim(),
      gender: form.gender.value,
      birth_date: form.birth_date.value || '',
      phone: form.phone.value.trim() || '',
      nationality: form.nationality.value || '',
      religion: form.religion.value || '',
      registration_date: (new Date()).toISOString().slice(0,10)
    };

    try {
      const res = await fetch('index.php?p=api/register', {
        method: 'POST',
        headers: {
          'Content-Type':'application/json',
          'X-CSRF-TOKEN': document.getElementById('csrf_token').value,
          'Accept':'application/json'
        },
        body: JSON.stringify(payload)
      });
      const json = await res.json();
      if (res.ok && json.status === 'success') {
        Swal.fire({icon:'success', title:'Saved', text: json.message});
        form.reset();
      } else {
        const msg = Array.isArray(json.message) ? json.message.join('\\n') : json.message;
        Swal.fire({icon:'error', title:'Error', text: msg});
      }
    } catch (err) {
      Swal.fire({icon:'error', title:'Error', text: 'Network or server error'});
    }
  }, false);
})();