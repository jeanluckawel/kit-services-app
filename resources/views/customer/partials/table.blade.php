@foreach($customers as $customer)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->rccm }}</td>
        <td>{{ $customer->nif }}</td>
        <td>{{ $customer->ville }}</td>
        <td>{{ $customer->telephone }}</td>
        <td>{{ $customer->email }}</td>
        <td class="text-center">
            <div class="d-inline-flex gap-1">
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this customer?')" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
