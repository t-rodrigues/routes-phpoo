<?php

namespace app\database\models;

class Pagination
{
    private int $currentPage = 1;
    private int $totalPages;
    private int $linksPerPage = 5;
    private int $itemsPerPage = 10;
    private int $totalItems;
    private string $pageIdentifier = 'page';

    public function setTotalItems(int $totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function setPageIdentifier(string $pageIdentifier): void
    {
        $this->pageIdentifier = $pageIdentifier;
    }

    public function setItemsPerPage(int $itemsPerPage): void
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getTotal(): int
    {
        return $this->totalItems;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    private function calculation(): string
    {
        $this->currentPage = $_GET[$this->pageIdentifier] ?? 1;
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
        return "limit {$this->itemsPerPage} offset {$offset}";
    }

    public function dump(): string
    {
        return $this->calculation();
    }

    public function links(): string
    {
        $links = "<ul class='pagination pagination-lg'>";

        if ($this->currentPage > 1) {
            $previous = $this->currentPage - 1;
            $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $previous]));
            $first = http_build_query((array_merge($_GET, [$this->pageIdentifier => 1])));
            $links .= "<li class='page-item'><a class='page-link' href='?{$first}'>Primeira</a></li>";
            $links .= "<li class='page-item'><a class='page-link' href='?{$linkPage}'>Anterior</a></li>";
        }

        for ($i = $this->currentPage - $this->linksPerPage; $i <= $this->currentPage + $this->linksPerPage; $i++) {
            if ($i > 0 && $i <= $this->totalPages) {
                $active = $this->currentPage === $i ? 'active' : '';
                $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $i]));
                $links .= "<li class='page-item {$active}'><a class='page-link' href='?{$linkPage}'>$i</a></li>";
            }
        }

        if ($this->totalPages) {
            $next = $this->currentPage + 1;
            $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $next]));
            $last = http_build_query((array_merge($_GET, [$this->pageIdentifier => $this->totalPages])));
            $links .= "<li class='page-item'><a class='page-link' href='?{$linkPage}'>Próxima</a></li>";
            $links .= "<li class='page-item'><a class='page-link' href='?{$last}'>Última</a></li>";
        }

        $links .= "</ul>";
        return $links;
    }
}
