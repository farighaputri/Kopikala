let transactions = [];

document.addEventListener('DOMContentLoaded', () => {
    fetch('/api/transactions')
        .then(res => res.json())
        .then(data => {
            transactions = data.transactions;

            document.getElementById('trx-date').innerText = data.date;
            document.getElementById('total-order').innerText = data.total_order;
            document.getElementById('total-sales').innerText =
                'Rp ' + data.total_sales.toLocaleString('id-ID');

            render(transactions);
        });

    document.getElementById('searchInput').addEventListener('input', filterData);
    document.getElementById('statusFilter').addEventListener('change', filterData);
    document.getElementById('locationFilter').addEventListener('change', filterData);
});

function render(data) {
    const body = document.getElementById('transactionBody');
    body.innerHTML = '';

    data.forEach((item, i) => {
        body.innerHTML += `
            <tr>
                <td>${String(i + 1).padStart(2, '0')}</td>
                <td>${item.order_id}</td>
                <td>${item.time}</td>
                <td>${item.customer}</td>
                <td>${item.qty}</td>
                <td><span class="badge ${statusClass(item.status)}">${item.status}</span></td>
                <td><span class="badge ${locationClass(item.location)}">${item.location}</span></td>
                <td>Rp ${item.total.toLocaleString('id-ID')}</td>
                <td class="action">
                    <span class="icon delete"></span>
                    <span class="icon view"></span>
                </td>
            </tr>
        `;
    });
}

function filterData() {
    const s = searchInput.value.toLowerCase();
    const st = statusFilter.value;
    const loc = locationFilter.value;

    const filtered = transactions.filter(t =>
        t.order_id.toLowerCase().includes(s) &&
        (st === '' || t.status === st) &&
        (loc === '' || t.location === loc)
    );

    render(filtered);
}

function statusClass(s) {
    return s === 'Waiting Confirmation' ? 'waiting' :
           s === 'Order Ready' ? 'ready' : 'finished';
}

function locationClass(l) {
    return l === 'Semeru' ? 'semeru' : 'djuanda';
}
