import { ChangeDetectionStrategy, Component, DestroyRef, inject, signal } from '@angular/core';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { interval, startWith, switchMap } from 'rxjs';
import { HealthService } from '../../../core/services/health.service';

@Component({
  selector: 'back-health-check',
  imports: [],
  templateUrl: './health-check.component.html',
  styles: ``,
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class HealthCheck {
  readonly status = signal(false);

  private healthService = inject(HealthService);
  private destroyRef = inject(DestroyRef);

  constructor() {
    interval(5000)
      .pipe(
        startWith(0),
        switchMap(() => this.healthService.checkStatus()),
        takeUntilDestroyed(this.destroyRef),
      )
      .subscribe({
        next: (response) => {
          this.status.set(response.status === 'OK');
        },
        error: () => {
          this.status.set(false);
        },
      });
  }
}
