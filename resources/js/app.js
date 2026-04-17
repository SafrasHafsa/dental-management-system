import './bootstrap'
import Alpine from 'alpinejs'
import Collapse from '@alpinejs/collapse'

// Alpine plugins
Alpine.plugin(Collapse)

// ─── Global Alpine components ──────────────────────────────

// Dropdown
Alpine.data('dropdown', () => ({
    open: false,
    toggle() { this.open = !this.open },
    close() { this.open = false },
}))

// Flash message auto-dismiss
Alpine.data('flash', (duration = 4000) => ({
    show: true,
    init() {
        setTimeout(() => { this.show = false }, duration)
    },
}))

// Confirm dialog
Alpine.data('confirmAction', (message = 'Are you sure?') => ({
    confirm(formEl) {
        if (window.confirm(message)) {
            formEl.submit()
        }
    }
}))

// Sidebar toggle (mobile)
Alpine.data('sidebar', () => ({
    open: false,
    toggle() { this.open = !this.open },
    close() { this.open = false },
}))

// ─── Generic CRUD modal (used by most list pages) ──────────
Alpine.data('crudModal', (cfg = {}) => ({
    showModal: false,
    mode: 'create',
    form: {},
    errors: {},
    loading: false,
    defaults: cfg.defaults || {},

    openCreate() {
        this.mode = 'create'
        this.form = { ...this.defaults }
        this.errors = {}
        this.showModal = true
    },
    openEdit(data) {
        this.mode = 'edit'
        this.form = { ...data }
        this.errors = {}
        this.showModal = true
    },
    close() { this.showModal = false },

    async submit() {
        this.loading = true
        this.errors = {}
        const isEdit = this.mode === 'edit'
        const url  = isEdit ? (cfg.updateUrl + '/' + this.form.id) : cfg.storeUrl
        const method = isEdit ? 'PUT' : 'POST'
        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(this.form),
            })
            if (res.status === 422) {
                const body = await res.json()
                this.errors = body.errors || {}
            } else if (res.ok) {
                this.close()
                location.reload()
            } else {
                alert('An error occurred. Please try again.')
            }
        } catch (e) { console.error(e) }
        finally { this.loading = false }
    },

    async del(id, deleteUrl) {
        if (!confirm('Are you sure you want to delete this?')) return
        const res = await fetch(deleteUrl + '/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        if (res.ok) location.reload()
        else alert('Could not delete. It may be in use.')
    },
}))

window.Alpine = Alpine
Alpine.start()
