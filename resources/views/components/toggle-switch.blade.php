<div class="relative w-12 h-6">
    <input type="checkbox" id="toggle" class="hidden toggle-input">
    <label for="toggle" class="toggle-label"></label>
</div>

<style>


    /* Pasek przełącznika */
    .toggle-label {
        display: block;
        width: 100%;
        height: 100%;
        background: #ccc;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s;
    }

    /* Kółko przełącznika */
    .toggle-label::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: #fff;
        border-radius: 50%;
        top: 2.5px;
        left: 2.5px;
        transition: transform 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Stan aktywny */
    .toggle-input:checked + .toggle-label {
        background: #007bff;
    }

    .toggle-input:checked + .toggle-label::after {
        transform: translateX(25px);
    }
</style>

<script>
    document.querySelector('#toggle').addEventListener('change', function () {
        console.log(this.checked ? 'Włączony' : 'Wyłączony');
    });
</script>
