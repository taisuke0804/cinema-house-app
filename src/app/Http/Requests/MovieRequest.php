<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Consts\Genre;
use Illuminate\Validation\Rule;

class MovieRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    $genre = Genre::GENRE_LIST;
    $genre_key = array_keys($genre);

    return [
      'title' => ['required', 'string', 'max:255'],
      'production_year' => ['required', 'integer', 'digits:4'],
      'genre' => ['required', 'integer', Rule::in($genre_key)],
      'description' => ['nullable', 'string', 'max:1000'],
      'poster_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
    ];
  }
}
