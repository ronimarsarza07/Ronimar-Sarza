<?php
namespace App;
final class CandidateService {
    public function __construct(private CandidateRepository $candidates) {}
    public function save(array $input, ?int $id): void {
        $data = ['name'=>trim((string)($input['name'] ?? '')), 'position'=>trim((string)($input['position'] ?? '')), 'party'=>trim((string)($input['party'] ?? '')), 'platform'=>trim((string)($input['platform'] ?? ''))];
        if ($data['name'] === '' || mb_strlen($data['name']) > 100) throw new \InvalidArgumentException('Ilagay ang pangalan (hanggang 100 character).');
        if ($data['position'] === '' || mb_strlen($data['position']) > 80) throw new \InvalidArgumentException('Ilagay ang posisyon (hanggang 80 character).');
        if (mb_strlen($data['party']) > 100 || mb_strlen($data['platform']) > 1000) throw new \InvalidArgumentException('Masyadong mahaba ang party o platform.');
        if ($id && !$this->candidates->find($id)) throw new \InvalidArgumentException('Hindi makita ang record na ie-edit.');
        $id ? $this->candidates->update($id, $data) : $this->candidates->create($data);
    }
    public function remove(int $id): void {
        if ($id < 1 || !$this->candidates->find($id)) throw new \InvalidArgumentException('Hindi makita ang record na ia-archive.');
        $this->candidates->archive($id);
    }
}
