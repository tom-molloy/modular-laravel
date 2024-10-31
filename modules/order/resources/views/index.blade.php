<a href={{ route("orders.checkout") }}>
    Creat Order
</a>
<table>
    <thead>
        <td>ID</td>
        <td>Status</td>        
        <td>Created at</td>
    </thead>
    @foreach ($orders as $order)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->status }}</td> 
        <td>{{ $order->created_at }}</td>
        <td>
            <a href=>view</a>
        </td>
    </tr>
    @endforeach
</table>