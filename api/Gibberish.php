<?php

class Gibberish
{
    const AVG_SENTENCE_TIME = 5; // Seconds
    const SENTENCES_PER_PARAGRAPH = 5;

    private $start = [
        'Sendo que ',
        'Por outro lado, ',
        'Assim mesmo, ',
        'Não poderemos esquecer que ',
        'Do mesmo modo, ',
        'A prática mostra que ',
        'Nunca é demais insistir, uma vez que ',
        'A experiência mostra que ',
        'É fundamental ressaltar que ',
        'O incentivo ao avanço tecnológico, assim como '
    ];
    private $action = [
        'a execução deste processo ',
        'a complexidade dos estudos efectuados ',
        'a expansão da nossa actividade ',
        'a atual estrutura da organização ',
        'o novo modelo estrutural aqui preconizado ',
        'o desenvolvimento de formas distintas de atuação ',
        'a constante divulgação das informações ',
        'a consolidação das estruturas ',
        'a análise dos diversos resultados ',
        'o início do programa de formação de atitudes '
    ];
    private $conclusion = [
        'obriga-nos à análise ',
        'cumpre um papel essencial de formação ',
        'exige a precisão e a definição ',
        'auxilia a preparação e a definição ',
        'contribui para a correta determinação ',
        'assume importante posição na definição ',
        'facilita a definição ',
        'prejudica a percepção da importância ',
        'oferece uma oportunidade de verificação ',
        'acarreta um processo de reformulação '
    ];
    private $subject = [
        'das nossas opções de desenvolvimento no futuro. ',
        'das nossas metas financeiras e administrativas. ',
        'dos conceitos de participação geral. ',
        'das atitudes e das atribuições da directoria. ',
        'das novas proposições. ',
        'das opções básicas para o sucesso do programa. ',
        'do nosso sistema de formação de quadros. ',
        'das condições apropriadas para os negócios. ',
        'dos índices pretendidos. ',
        'das formas de acção. '
    ];

    public function randomString(string $property): string
    {
        if (!isset($this->$property)) {
            throw new Exception("Property $property doesn't exist.");
        } elseif (empty($this->$property)) {
            // Ran out of options, start repeating
            $this->$property = $this->repeats[$property];

            // But make sure we at least don't repeat the exact last item
            $last = array_pop($this->repeats[$property]);
            $this->repeats[$property] = [$last];
        }

        $values = &$this->$property;

        // Randomize a value
        $rand = rand(0, (count($values) - 1));
        $value = $values[$rand];

        // Make sure we avoid repeating values too often
        $this->repeats[$property][] = $values[$rand];
        unset($values[$rand]);
        $values = array_values($values);

        return $value;
    }

    public function buildSentence(bool $skipStart = false): string
    {
        return ($skipStart ? '' : $this->randomString('start')) .
            $this->randomString('action') .
            $this->randomString('conclusion') .
            $this->randomString('subject');
    }

    public function buildSentences(int $time = 60, $start = 'Caros colegas, '): string
    {
        // First sentence has a customized start
        $text = "\t" . $start . $this->buildSentence(true);

        // Generate enough sentences to fill the total time
        $sentenceCounter = 1;
        $sentenceTotal = ceil($time / self::AVG_SENTENCE_TIME);
        for ($i = 1; $i < $sentenceTotal; $i++) {
            // Track paragraphs
            $sentenceCounter++;
            if ($sentenceCounter > self::SENTENCES_PER_PARAGRAPH) {
                $sentenceCounter = 0;
                $text .= "\n\n\t";
            }

            // Generate a random sentence
            $text .= $this->buildSentence();
        }

        return $text;
    }
}
