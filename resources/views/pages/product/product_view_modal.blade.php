<!-- View Modal -->
<div class="modal fade" id="product_view-{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Product Views</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col">Views Today</th>
                            <th class="text-center" scope="col">Views Last 30 Days</th>
                            <th class="text-center" scope="col">Views Last 90 Days</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    {{ views($record)->period(\CyrildeWit\EloquentViewable\Support\Period::since(today()))->count() }}
                                </td>
                                <td class="text-center">
                                    {{ views($record)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(30))->count() }}
                                </td>
                                <td class="text-center">
                                    {{ views($record)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(90))->count() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end me-4">
                <p class="uppercase">TOTAL VIEWS: {{ views($record)->count() }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>
