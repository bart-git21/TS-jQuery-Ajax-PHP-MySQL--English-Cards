<script defer>
    $(document).ready(function () {
        $.ajax({
            url: "/api/english/",
            method: "GET"
        })
            .done((response) => {
                response.forEach(e => $("#englishListsSelect").append(`<option value='${e.id}'>${e.id}</option>`));
            })
            .fail((xhr, status, error) => { console.log(xhr.status) });
        $("#englishListsSelect").on("change", function () {
            const id = $(this).val();
            $.ajax({
                url: `/api/english/index.php/${id}`,
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            })
                .done((response) => $("#textarea").val(response.list))
                .fail((xhr, status, error) => { console.log(xhr.status) })
                .always(() => { });
        });
        $("#createList").on("click", function () {
            const list = $("#textarea").val();
            $.ajax({
                url: "/api/english/",
                method: "POST",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: JSON.stringify({ list }),
            })
                .done(() => alert("Success!"))
                .fail(() => { })
                .always(() => { });
        });
        $("#updateList").on("click", function () {
            const id = $("#englishListsSelect").val();
            const textareaValue = $("#textarea").val();
            $.ajax({
                url: `/api/english/index.php/${id}`,
                method: "PUT",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: JSON.stringify({ id, textareaValue }),
            })
                .done(() => alert("List updated successfully"))
                .fail((xhr, status, error) => { console.log(xhr.status) })
        });
    });
</script>

<div class="card h-100">
    <div class="card-body">
        <textarea class="btn--red w-100 h-100 lh-sm p-1" spellcheck="false" placeholder="Leave the sentences here"
            id="textarea"></textarea>
    </div>
    <div class="d-flex">
        <select class="form-select" aria-label="Default select example" id="englishListsSelect">
            <option selected>Retrieve the list with the ID</option>
        </select>
    </div>
    <div class="btn-group d-flex justify-content-around p-2 areaBtn" role="group" aria-label="Basic outlined example">
        <button type="button" class="btn btn--red" id="createList">
            Create
        </button>
        <button type="button" class="btn btn--red" id="updateList">
            Edit
        </button>
    </div>
</div>

<style scoped>
    .areaBtn {
        gap: 15px;
    }
</style>