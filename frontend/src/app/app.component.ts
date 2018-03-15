import { Component } from '@angular/core';

import { Statistics } from './statistics.model';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

  comparing = false;

  stats: Statistics;

  constructor() {
    this.stats = new Statistics();
  }

  setStats(respondsStats: Statistics): void {
    this.stats = respondsStats;
    console.log(respondsStats.class);
  }

  performComparison(): boolean {
    console.log("Cool");
    return false;
  }

  back(): boolean {
    this.comparing = false;
    return false;
  }
}
