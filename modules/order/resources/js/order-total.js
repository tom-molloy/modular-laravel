function caclulateTotals () {
    const table = document.getElementById('price').value
    const orderTotal = 0

    for( var i = 1; i < table.rows.length - 1; i++ ){
        let productPrice = table.rows[i].getElementById('price')
        let productQuantity = table.rows[i].getElementById('quantity')
        productTotal = parseFloat( productPrice * productQuantity )
        table.rows[i].getElementById('sub-total').innerHTML = productTotal
        orderTotal =+ productTotal;
    }
    document.getElementById('total').innerHTML = orderTotal;
}
