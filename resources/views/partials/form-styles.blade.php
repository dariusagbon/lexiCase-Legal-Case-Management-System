{{-- resources/views/partials/form-styles.blade.php --}}
<style>
    .form-section {
        background: white;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .form-section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem;
        background: #fafaf8;
        border-bottom: 1px solid #f3f2ef;
    }

    .form-section-body {
        padding: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .field-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--navy);
    }

    .field-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d0cb;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }

    .field-input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    .field-input.err {
        border-color: #f87171;
        background-color: rgba(248, 113, 113, 0.05);
    }

    .field-input.err:focus {
        box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.1);
    }

    .field-error {
        margin-top: 0.375rem;
        font-size: 0.75rem;
        color: #dc2626;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background-color: var(--gold);
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-submit:hover {
        background-color: #c49d44;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background-color: #f3f2ef;
        color: var(--navy);
        font-size: 0.875rem;
        font-weight: 500;
        border: 1px solid #d1d0cb;
        border-radius: 0.375rem;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .btn-cancel:hover {
        background-color: #e8e7e2;
    }
</style>
