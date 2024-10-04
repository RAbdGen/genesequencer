<?php
namespace Dna;
namespace Dna;

use Jfredon\FakeAnalyticsData\DnaProvider;

class DnaProviderStub extends DnaProvider {
    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function generate(?int $tupleNumber = null): array {
        return $this->data;
    }
}

