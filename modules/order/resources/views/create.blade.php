<h2>Create Order</h2>

<form action={{ route("orders.checkout") }} method="POST">
    <table id='table'>
        <thead>
            <td>
                Product
            </td>
            <td>
                Price ($)
            </td>
            <td>
                Quantity
            </td>
        </thead>
    
    @foreach($products as $product)
        <tr>
            <td>
                <label for="{{ $product->name }}">{{ $product->name }}</label>
            </td>
            <td>
                {{ number_format($product->price_in_cents / 100, 2) }}
            </td>
            <td>
                <input
                    name="products[{{ $product->id }}]"
                    type="number"
                    min="1"
                    value="1"
                />
            </td>
        </tr>
    @endforeach()
    </table>

    <button type="submit">Submit</button>
</form>

