<?php


global $user_ID;


//Получаем все анкеты
$args = array(
	'post_type'   => 'question',
	'numberposts' => - 1,
);

$questions = get_posts( $args );

$questionsCount   = count( $questions );
$questionsCounter = 1;


// Подготовка и сортировка массива
$questionsArray = array();

foreach ( $questions as $question ) {
	$meta               = get_post_meta( $question->ID );
	$questionsArrayItem = array();

	$questionsArrayItem['title'] = $question->post_title;
	$questionsArrayItem['order'] = $meta['порядок_в_анкете'][0];
	$questionsArrayItem['max']   = $meta['можно_выбрать_вариантов'][0];

	$options = [];

	for ( $index = 0; $index < 30; $index ++ ) {
		if ( isset( $meta[ 'варианты_ответа_' . $index . '_варианты_ответа' ] ) ) {
			$options[] = [ 'title' => $meta[ 'варианты_ответа_' . $index . '_варианты_ответа' ][0] ];
		}
	}

	$options[] = [ 'title' => 'Другое' ];

	$questionsArrayItem['options'] = $options;

	$questionsArray[] = $questionsArrayItem;
}

function array_sort( $array, $on, $order = SORT_ASC ) {
	$new_array      = array();
	$sortable_array = array();

	if ( count( $array ) > 0 ) {
		foreach ( $array as $k => $v ) {

			if ( is_array( $v ) ) {
				foreach ( $v as $k2 => $v2 ) {
					if ( $k2 == $on ) {
						$sortable_array[ $k ] = $v2;
					}
				}
			} else {
				$sortable_array[ $k ] = $v;
			}
		}

		switch ( $order ) {
			case SORT_ASC:
				asort( $sortable_array );
				break;
			case SORT_DESC:
				arsort( $sortable_array );
				break;
		}

		foreach ( $sortable_array as $k => $v ) {
			$new_array[ $k ] = $array[ $k ];
		}
	}

	return $new_array;
}

$questionsArraySort = array_sort( $questionsArray, 'order', SORT_ASC );

$args = array(
	'post_type'   => 'answers',
	'numberposts' => - 1,
);

$results = get_posts( $args );


foreach ( $results as $resultKey => $resultValue ) {
	$resultsArray = json_decode( $results[ $resultKey ]->post_content );

	foreach ( $resultsArray as $subResultKey => $subResultValue ) {
		$title   = $resultsArray[ $subResultKey ]->title;
		$answers = $resultsArray[ $subResultKey ]->answers;

		foreach ( $questionsArraySort as $key => $value ) {


			if ( $title !== $questionsArraySort[ $key ]['title'] ) {
				continue;
			}

			$otherArray = [];

			$optionTitles = [];

			foreach ( $questionsArraySort[ $key ]['options'] as $subKey => $subValue ) {
				$optionTitles[] = $questionsArraySort[ $key ]['options'][ $subKey ]['title'];
			}

			foreach ( $questionsArraySort[ $key ]['options'] as $subKey => $subValue ) {


				if ( $questionsArraySort[ $key ]['options'][ $subKey ]['title'] === 'Другое' ) {
					foreach ( $answers as $answer ) {

						if ( ! in_array( $answer, $optionTitles ) ) {
							$questionsArraySort[ $key ]['options'][ $subKey ]['items'][ $resultKey ][] = $answer;
						}
					}

					if ( count( $questionsArraySort[ $key ]['options'][ $subKey ]['items'][ $resultKey ] ) === 0 ) {
						$questionsArraySort[ $key ]['options'][ $subKey ]['items'][ $resultKey ][] = 0;
					}

					continue;
				}


				foreach ( $answers as $answer ) {
					if ( $questionsArraySort[ $key ]['options'][ $subKey ]['title'] === $answer ) {
						$questionsArraySort[ $key ]['options'][ $subKey ]['items'][ $resultKey ][] = 1;
					} else {
						$questionsArraySort[ $key ]['options'][ $subKey ]['items'][ $resultKey ][] = 0;
					}
				}


			}
		}

	}
}

echo '<div class="answers-toggle">Показать все ответы</div>';

echo '<table class="answers">';

echo '<tr>';
echo '<td>';
echo 'Вопрос';
echo '</td>';

foreach ( $results as $resultKey => $resultValue ) {
	echo '<td class="answers__user">';
	echo get_user_by( 'ID', $results[ $resultKey ]->post_author )->user_login;
	echo '</td>';
}

echo '<td>';
echo 'Итого';
echo '</td>';
echo '</tr>';

foreach ( $questionsArraySort as $question ) {
	echo '<tr>';
	echo '<th colspan="10000">';
	echo $question['title'];
	echo '</th>';
	echo '</tr>';

	foreach ( $question['options'] as $item ) {
		echo '<tr>';
		echo '<td>';
		echo $item['title'];
		echo '</td>';

		$counter = 0;

		foreach ( $item['items'] as $answer ) {
			$render = '';

			foreach ( $answer as $answerValue ) {
				if ( $answerValue === 0 ) {
					continue;
				}

				$render  = $answerValue;
				$counter += 1;
			}

			echo '<td class="answers__user">';
			echo $render;
			echo '</td>';
		}

		echo '<td>';
		echo $counter;
		echo '</td>';

		echo '</tr>';
	}
}

echo '</table>';
