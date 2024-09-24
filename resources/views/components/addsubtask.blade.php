<div class="modal fade" id="addsubtask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addsubtask" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addsubtask">Add New Subtask</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('store.subtask', @$task['id'])}}" method="post" class="">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label mt-2">Title :</label>
                                        <input type="text" class="form-control" value="" name="title" placeholder="Title">

                                        <label class="form-label mt-2">Description :</label>
                                        <textarea type="text" class="form-control" value="" name="description" rows="3" placeholder="Description"></textarea>

                                        <label class="form-label mt-2">Task Type :</label>
                                        <select class="form-select" name="task_type_id" id="taskType" onchange="toggleFields()">
                                            <option value="">Choose...</option>
                                            <option value="1">One-Time</option>
                                            <option value="2">Recurring</option>
                                        </select>
                                        <!-- Deadline Field (Initially Hidden) -->
                                        <div id="deadlineField" class="mt-2" style="display: none;">
                                            <label class="form-label">Deadline :</label>
                                            <input type="date" class="form-control" value="" name="deadline" placeholder="Deadline">
                                        </div>
                                        <!-- Days Field (Initially Hidden) -->
                                        <div id="daysField" class="card border-dark mt-2" style="display: none;">
                                            <div class="card-body lh-lg">
                                                <label class="form-label">Select Days :</label>
                                                <br>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Sunday" id="sunday" autocomplete="off">
                                                <label class="btn" for="sunday">Sunday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Monday" id="monday" autocomplete="off">
                                                <label class="btn" for="monday">Monday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Tuesday" id="tuesday" autocomplete="off">
                                                <label class="btn" for="tuesday">Tuesday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Wednesday" id="wednesday" autocomplete="off">
                                                <label class="btn" for="wednesday">Wednesday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Thursday" id="thursday" autocomplete="off">
                                                <label class="btn" for="thursday">Thursday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Friday" id="friday" autocomplete="off">
                                                <label class="btn" for="friday">Friday</label>
                                                <input type="checkbox" class="btn-check" name="days[]" value="Saturday" id="saturday" autocomplete="off">
                                                <label class="btn" for="saturday">Saturday</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>