@extends('layouts.app')
@section('css')
    <style>
        .select2-container--default .select2-results__option--selected {
            display: none;
        }
    </style>
@endsection
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center mt-5">
                <h2>منتج {{$product->name}}</h2>
            </div>
            <div class="col-md-12 text-center mt-5">
                <h2>Select2</h2>
            </div>
            <div class="col-md-8 mt-5 offset-2">
                <select id="product" class="form-control p-3" name="livesearch" multiple="multiple">
                </select>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {


            $('#product').select2({
                placeholder: 'اختيار منتج',
                ajax: {
                    url: "{{route('ajax-products')}}",
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            search: params.term,
                            except: "{{$product->id}}"
                        }
                    },
                    processResults: function (data) {
                        let products = data.products
                        return {
                            results: $.map(products, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },

                },


                templateSelection: function (data, container) {
                    $('.select2-results__option--selected').hide()
                    // Add custom attributes to the <option> tag for the selected option
                    // $(data.element).attr('data-custom-attribute', data.customValue);
                    return data.text;
                }
            });

            function matchCustom(params, data) {
                console.log(data, 'amer')
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                var sregex = `(^${params.term}|[ :\\-\\/\\(\\)]${params.term})`;

                //var regex = new RegExp(sregex);// case sensitive
                var regex = new RegExp(sregex, 'i'); // nocase
                if (data.text.match(regex)) {
                    var modifiedData = $.extend({}, data, true);
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

        })


    </script>
@endsection
