<?php

namespace Rmsramos\Activitylog\Infolists\Components;

use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Concerns\CanAllowHtml;
use Filament\Infolists\Components\Entry;
use Filament\Support\Concerns\HasExtraAttributes;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Rmsramos\Activitylog\Infolists\Concerns\HasModifyState;

class TimeLineTitleEntry extends Entry
{
    use CanAllowHtml;
    use HasExtraAttributes;
    use HasModifyState;

    protected ?Closure $configureTitleUsing = null;

    protected ?Closure $shouldConfigureTitleUsing = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configureTitleEntry();
    }

    protected string $view = 'activitylog::filament.infolists.components.time-line-title-entry';

    public function configureTitleUsing(?Closure $configureTitleUsing): TimeLineTitleEntry
    {
        $this->configureTitleUsing = $configureTitleUsing;

        return $this;
    }

    public function shouldConfigureTitleUsing(?Closure $condition): TimeLineTitleEntry
    {
        $this->shouldConfigureTitleUsing = $condition;

        return $this;
    }

    private function configureTitleEntry()
    {
        $this
            ->hiddenLabel()
            ->modifyState(fn ($state) => $this->modifiedTitle($state));
    }

    private function modifiedTitle($state): string|HtmlString|Closure
    {
        if ($this->configureTitleUsing !== null && $this->shouldConfigureTitleUsing !== null && $this->evaluate($this->shouldConfigureTitleUsing)) {
            return $this->evaluate($this->configureTitleUsing, ['state' => $state]);
        } else {
            if ($state['description'] == $state['event']) {
                $className = $this->getClassName($state);

                $causerName = $this->getCauserName($state['causer']);
                $update_at  = Carbon::parse($state['update'])->translatedFormat(config('filament-activitylog.datetime_format'));

                return new HtmlString(
                    sprintf(
                        __('activitylog::timeline.title.modifiedTitle'),
                        $className,
                        __('activitylog::timeline.event.'.$state['event']),
                        $causerName,
                        $update_at
                    )
                );
            }
        }

        return '';
    }

    public function getClassName(array $state): string {
        if ( property_exists($state['subject'], 'activityTitleName') && ! empty($state['subject']::$activityTitleName)) {
            return $state['subject']::$activityTitleName;
        } else if (\method_exists($state['subject'], 'activityTitle')) {
            return $state['subject']::activityTitle();
        }

        return Str::lower(Str::snake(class_basename($state['subject']), ' '));
    }
}
