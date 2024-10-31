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
                {{ $product->price }}
            </td>
            <td>
                <input
                    name="products[{{ $product->name }}]"
                    type="number"
                />
            </td>
        </tr>
    @endforeach()
    </table>

    <button type="submit">Submit</button>
</form>

