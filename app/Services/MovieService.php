<?php  

namespace App\Services;

use App\Repositories\MovieRepository;
use Illuminate\Support\Arr;

class MovieService
{
	private $repository;

	public function __construct(MovieRepository $movieRepository) 
	{
		$this->repository = $movieRepository;
	}

	public function showTrendingMovies()
	{
		$movies = $this->repository->findTrending();
	
		return $this->formatMovies($movies);
	}

	public function showMovieDetails($id)
	{
		$movie = $this->repository->find($id);
		
		return $this->formatOnlyOneMovie($movie);
	}

	public function showMoviesByName($name) {
		$movies = $this->repository->findByName($name);

		return $this->formatMovies($movies);
	}

	public function showMoviesByGenre($genre) {
		$movies = $this->repository->findByGenre($genre);
	
		return $this->formatMovies($movies);
	}

	private function formatMovies($movies)
	{	
		
		foreach ($movies as $key => $movie) {
			$movies[$key] = collect($movie)->only(['id', 'title', 'genre_ids', 'poster_path', 'overview'])->all();
		}

		// uasort($movies, function($a, $b){
		//     return strcmp($a['title'], $b['title']);
		// });

		return $movies;
	}

	private function formatOnlyOneMovie($movie) 
	{
	
		return collect($movie)->only(['id', 'title', 'genres', 'poster_path', 'overview']);
	
	}
}