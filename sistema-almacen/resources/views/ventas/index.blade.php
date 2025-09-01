@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Módulo de Venta</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('ventas.history') }}" class="btn btn-sm btn-info">Ver Historial de Ventas</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('ventas.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="cliente_id" class="form-label">Seleccionar Cliente:</label>
        <select name="cliente_id" class="form-select">
            <option value="">Seleccione un cliente (opcional)</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre_completo }}</option>
            @endforeach
        </select>
        <a href="{{ route('clientes.create') }}">Crear nuevo cliente</a>
    </div>

    <h3>Productos</h3>
    <table class="table table-bordered" id="productos-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            </tbody>
    </table>

    <button type="button" class="btn btn-secondary mb-3" id="add-product">Agregar Producto</button>

    <div class="mb-3">
        <label for="descuento" class="form-label">Descuento:</label>
        <input type="number" name="descuento" id="descuento" value="0" step="0.01" class="form-control">
    </div>

    <h3>Resumen de la Venta</h3>
    <div class="card p-3">
        <p>Subtotal: <span id="subtotal-display">0.00</span></p>
        <p>Descuento: <span id="descuento-display">0.00</span></p>
        <p class="fw-bold">Total: <span id="total-display">0.00</span></p>
    </div>
    
    <button type="submit" class="btn btn-success mt-3">Finalizar Venta</button>
</form>

<script>
    const productos = <?php echo json_encode($productos->toArray()); ?>;
    const addProductBtn = document.getElementById('add-product');
    const productosTableBody = document.querySelector('#productos-table tbody');
    const subtotalDisplay = document.getElementById('subtotal-display');
    const descuentoInput = document.getElementById('descuento');
    const totalDisplay = document.getElementById('total-display');

    function renderRow(index) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="productos[${index}][id]" class="form-select product-select" required>
                    <option value="">Seleccione un producto</option>
                    ${productos.map(p => `<option value="${p.id}" data-precio="${p.precio_unitario}">${p.nombre} - (Stock: ${p.stock_actual})</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" min="1" required></td>
            <td class="precio-unitario-display">0.00</td>
            <td class="subtotal-item-display">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
        `;
        productosTableBody.appendChild(row);
    }

    function calculateTotals() {
        let subtotal = 0;
        const rows = productosTableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const select = row.querySelector('.product-select');
            const cantidadInput = row.querySelector('.cantidad-input');
            const precioDisplay = row.querySelector('.precio-unitario-display');
            const subtotalDisplay = row.querySelector('.subtotal-item-display');

            const productoId = select.value;
            const cantidad = cantidadInput.value;

            if (productoId && cantidad > 0) {
                const producto = productos.find(p => p.id == productoId);
                const subtotalItem = parseFloat(producto.precio_unitario) * parseFloat(cantidad);
                subtotal += subtotalItem;
                precioDisplay.textContent = parseFloat(producto.precio_unitario).toFixed(2);
                subtotalDisplay.textContent = subtotalItem.toFixed(2);
            } else {
                precioDisplay.textContent = '0.00';
                subtotalDisplay.textContent = '0.00';
            }
        });

        const descuento = parseFloat(descuentoInput.value) || 0;
        const total = subtotal - descuento;
        
        subtotalDisplay.textContent = subtotal.toFixed(2);
        document.getElementById('descuento-display').textContent = descuento.toFixed(2);
        totalDisplay.textContent = total.toFixed(2);
    }

    addProductBtn.addEventListener('click', () => {
        renderRow(productosTableBody.children.length);
    });

    productosTableBody.addEventListener('change', (e) => {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('cantidad-input')) {
            calculateTotals();
        }
    });

    descuentoInput.addEventListener('input', calculateTotals);

    productosTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

    // Inicializar con una fila
    renderRow(0);
</script>
@endsection